<?php

use App\Livewire\Tickets\ShowTicket;
use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\User;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on show page', function () {
    $ticket = Ticket::factory()->create();

    get(route('tickets.show', $ticket))
        ->assertSeeLivewire(ShowTicket::class)
        ->assertOk();
});

it('can show a ticket for an admin', function () {
    $ticket = Ticket::factory()->create();
    $category = Category::all()->random();
    $label = Label::all()->random();
    $ticket->categories()->attach($category);
    $ticket->labels()->attach($label);

    Livewire::test(ShowTicket::class, ['ticket' => $ticket])
        ->assertSee(ucfirst($ticket->title))
        ->assertSee(ucfirst($ticket->status))
        ->assertSee(ucfirst($ticket->priority))
        ->assertSee($ticket->user->name)
        ->assertSee($ticket->description)
        ->assertSee($category->name)
        ->assertSee($label->name);
});

it('is not allowed to show tickets from other users', function () {
    $user = User::factory()->create();
    login($user);

    $ticket = Ticket::factory()->create();

    Livewire::test(ShowTicket::class, ['ticket' => $ticket])
        ->assertForbidden();
});

it('is not allowed to show tickets from other agents', function () {
    $user = User::factory()->create();
    $user->assignRole(
        Role::whereName('Agent')->first()
    );
    login($user);

    $ticket = Ticket::factory()->create();

    Livewire::test(ShowTicket::class, ['ticket' => $ticket])
        ->assertForbidden();
});
