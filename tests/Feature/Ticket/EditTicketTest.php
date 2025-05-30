<?php

namespace Tests\Feature\Ticket;

use App\Livewire\Tickets\EditTicket;
use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\get;
use function Pest\Laravel\seed;
use function Pest\Livewire\livewire;
use function Tests\login;

beforeEach(function () {
    seed(PermissionSeeder::class);
    login();
});

it('has component on edit page', function () {
    $ticket = Ticket::factory()->create();

    get(route('tickets.edit', $ticket))
        ->assertSeeLivewire(EditTicket::class)
        ->assertOk();
});

it('can edit a ticket', function () {
    $user = User::factory()->create();
    $ticket = Ticket::factory()->recycle($user)->create([
        'title' => 'Test Title',
        'priority' => 'low',
        'description' => 'Test Description for ticket',
        'status' => 'open',
    ]);

    $newCategory = Category::whereName('Profile')->first();
    $newLabel = Label::whereName('Question')->first();
    livewire(EditTicket::class, ['ticket' => $ticket])
        ->set('form.title', 'New Title')
        ->set('form.priority', 'high')
        ->set('form.status', 'closed')
        ->set('form.description', 'New Description for ticket!!!!!!')
        ->set('form.selectedCategories', [$newCategory->id])
        ->set('form.selectedLabels', [$newLabel->id])
        ->call('save');

    $ticket->refresh();

    expect($ticket->title)->toEqual('New Title');
    expect($ticket->priority)->toEqual('high');
    expect($ticket->status)->toEqual('closed');
    expect($ticket->description)->toEqual('New Description for ticket!!!!!!');
    expect($ticket->user->id)->toEqual($user->id);
    expect($ticket->categories->first()->name)->toEqual($newCategory->name);
    expect($ticket->labels->first()->name)->toEqual($newLabel->name);
});

it('can upload attachments for the edited ticket', function () {
    Storage::fake('media');

    $ticket = Ticket::factory()->create([
        'title' => 'Test Title',
    ]);

    $files[] = UploadedFile::fake()->image('test.png');
    $files[] = UploadedFile::fake()->image('test2.png');

    livewire(EditTicket::class, ['ticket' => $ticket])
        ->set('form.title', 'New Title')
        ->set('form.priority', 'high')
        ->set('form.status', 'closed')
        ->set('form.description', 'New Description for ticket!!!!!!')
        ->set('form.attachments', $files)
        ->call('save');

    $ticket->refresh();

    foreach ($ticket->media as $media) {
        Storage::disk('media')->assertExists($media->getUrlGenerator('')->getPathRelativeToRoot());
    }
});

it('validates required fields', function (string $name, string $value) {
    $ticket = Ticket::factory()->create();

    livewire(EditTicket::class, ['ticket' => $ticket])
        ->set($name, $value)
        ->call('save')
        ->assertHasErrors($name);
})->with([
    ['form.title', ''],
    ['form.priority', ''],
    ['form.description', ''],
]);

it('is not allowed to reach this endpoint when logged in as default user', function () {
    login(User::factory()->create());

    $ticket = Ticket::factory()->create();

    get(route('tickets.edit', $ticket))
        ->assertForbidden();
});

it('is allowed to reach this endpoint as agent when assigned to the ticket', function () {
    $user = User::factory()->agent()->create();
    login($user);

    $ticket = Ticket::factory()->agent($user)->create();

    get(route('tickets.edit', $ticket))
        ->assertOk();
});

it('is not allowed to reach this endpoint as agent when not assigned to the ticket', function () {
    $user = User::factory()->agent()->create();
    login($user);

    $ticket = Ticket::factory()->create();

    get(route('tickets.edit', $ticket))
        ->assertForbidden();
});

it('can assign an agent to the ticket as admin', function () {
    $agent = User::factory()->agent()->create();
    $ticket = Ticket::factory()->create();

    livewire(EditTicket::class, ['ticket' => $ticket])
        ->set('form.agentAssigned', $agent->id)
        ->call('save');

    $ticket->refresh();

    expect($ticket->agent->id)->toEqual($agent->id);
});

it('can remove attachments from ticket', function () {
    Storage::fake('media');

    $ticket = Ticket::factory()->create();

    $uploadedFile1 = UploadedFile::fake()->image('test.png');
    $uploadedFile2 = UploadedFile::fake()->image('test2.png');

    $ticket->addMedia($uploadedFile1)->toMediaCollection('attachments');
    $ticket->addMedia($uploadedFile2)->toMediaCollection('attachments');

    expect($ticket->getMedia('attachments'))->toHaveCount(2);

    $firstMedia = $ticket->getFirstMedia('attachments');
    livewire(EditTicket::class, ['ticket' => $ticket])
        ->call('removeAttachment', $firstMedia);

    $ticket->refresh();
    expect($ticket->getMedia('attachments'))->toHaveCount(1);
});
