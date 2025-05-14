<?php

namespace Tests\Feature\User;

use App\Livewire\Tickets\ShowTicket;
use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\PermissionSeeder;

use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\seed;
use function Pest\Livewire\livewire;
use function Tests\login;

beforeEach(function () {
    seed(PermissionSeeder::class);
    login();
});

it('can delete a ticket', function () {
    $ticket = Ticket::factory()->create();

    livewire(ShowTicket::class, ['ticket' => $ticket])
        ->call('deleteTicket', $ticket);

    assertModelMissing($ticket);
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    $ticket = Ticket::factory()->create();

    livewire(ShowTicket::class, ['ticket' => $ticket])
        ->call('deleteTicket', $ticket)
        ->assertForbidden();
});

it('detaches categories/labels attached to the ticket after deleting ticket', function () {
    $category = Category::all()->first();
    $label = Label::all()->first();
    $ticket = Ticket::factory()->categories([$category])->labels([$label])->create();

    expect($ticket)->not->toBeNull();
    expect($ticket->categories)->toHaveCount(1);
    expect($ticket->labels)->toHaveCount(1);
    expect($category->tickets()->whereId($ticket->id)->get())->toHaveCount(1);
    expect($label->tickets()->whereId($ticket->id)->get())->toHaveCount(1);

    $ticket->delete();
    assertModelMissing($ticket);

    expect($category->tickets()->whereId($ticket->id)->get())->toHaveCount(0);
    expect($label->tickets()->whereId($ticket->id)->get())->toHaveCount(0);
});
