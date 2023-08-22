<?php

use App\Livewire\Tickets\CreateTicket;
use App\Mail\TicketCreated;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\UploadedFile;

use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on create page', function () {
    get(route('tickets.create'))
        ->assertSeeLivewire(CreateTicket::class)
        ->assertOk();
});

it('can create a new ticket', function () {
    Livewire::test(CreateTicket::class)
        ->set('form.title', 'Test Title')
        ->set('form.priority', 'low')
        ->set('form.description', 'This is a test description for ticket')
        ->call('save');

    $ticket = Ticket::whereTitle('Test Title')->first();
    expect($ticket)->not->toBeNull();
    expect($ticket->priority)->toEqual('low');
    expect($ticket->status)->toEqual('open');
    expect($ticket->description)->toEqual('This is a test description for ticket');
    expect($ticket->user->name)->toEqual('Jerry');
});

it('can upload files as attachments to the ticket', function () {
    Storage::fake('media');

    $files[] = UploadedFile::fake()->image('test.png');
    $files[] = UploadedFile::fake()->image('test2.png');

    Livewire::test(CreateTicket::class)
        ->set('form.title', 'Test Title')
        ->set('form.priority', 'low')
        ->set('form.description', 'This is a test description for ticket')
        ->set('form.attachments', $files)
        ->call('save');

    $ticket = Ticket::whereTitle('Test Title')->first();

    foreach ($ticket->media as $media) {
        Storage::disk('media')->assertExists($media->getUrlGenerator('')->getPathRelativeToRoot());
    }
});

it('sends an email to the admin with a link to assign an agent (edit ticket)', function () {
    Mail::fake();

    Livewire::test(CreateTicket::class)
        ->set('form.title', 'Test Title')
        ->set('form.priority', 'low')
        ->set('form.description', 'This is a test description for ticket')
        ->call('save');

    Mail::assertSent(TicketCreated::class);
});

it('has specific content in the ticket created email', function () {
    $ticket = Ticket::factory()->create();

    $mailable = new TicketCreated($ticket);
    $mailable->assertSeeInHtml($ticket->title);
    $mailable->assertSeeInHtml($ticket->user->name);
    $mailable->assertSeeInHtml(route('tickets.edit', $ticket));

    expect($mailable->subject)->toEqual('Ticket Created');
    $mailable->assertHasTo('admin@admin.com');
});

it('validates required fields', function (string $name, string $value) {
    Livewire::test(CreateTicket::class)
        ->set($name, $value)
        ->call('save')
        ->assertHasErrors($name);
})->with([
    'title' => ['form.title', ''],
    'priority' => ['form.priority', ''],
    'description' => ['form.description', ''],
]);

it('is not allowed to reach this endpoint when not logged in', function () {
    Auth::logout();

    get(route('tickets.create'))
        ->assertRedirectToRoute('login');

    Livewire::test(CreateTicket::class)
        ->set('form.title', 'Test Title')
        ->set('form.priority', 'low')
        ->set('form.description', 'This is a test description for ticket')
        ->call('save')
        ->assertForbidden();
});

it('is allowed to reach this endpoint when logged in', function () {
    login(User::factory()->create());

    get(route('tickets.create'))
        ->assertOk();

    Livewire::test(CreateTicket::class)
        ->set('form.title', 'Test Title')
        ->set('form.priority', 'low')
        ->set('form.description', 'This is a test description for ticket')
        ->call('save');
});
