<?php

namespace Tests\Feature\Ticket;

use App\Livewire\Tickets\ShowTicket;
use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\PermissionSeeder;

use function Pest\Laravel\get;
use function Pest\Laravel\seed;
use function Pest\Livewire\livewire;
use function Tests\login;

beforeEach(function () {
    seed(PermissionSeeder::class);
    login();
});

it('has component on show page', function () {
    $ticket = Ticket::factory()->create();

    get(route('tickets.show', $ticket))
        ->assertSeeLivewire(ShowTicket::class)
        ->assertOk();
});

it('can show a ticket for an admin', function () {
    $ticket = Ticket::factory()->categories()->labels()->create();
    $category = $ticket->categories->first();
    $label = $ticket->labels->first();

    livewire(ShowTicket::class, ['ticket' => $ticket])
        ->assertSee(ucfirst($ticket->title))
        ->assertSee(ucfirst($ticket->status))
        ->assertSee(ucfirst($ticket->priority))
        ->assertSee($ticket->user->name)
        ->assertSee(ucfirst($ticket->description))
        ->assertSee($category->name)
        ->assertSee($label->name);
});

it('is not allowed to show tickets from other users', function () {
    $user = User::factory()->create();
    login($user);

    $ticket = Ticket::factory()->create();

    get(route('tickets.show', $ticket))
        ->assertForbidden();
});

it('is not allowed to show tickets from other agents', function () {
    $agent = User::factory()->agent()->create();
    login($agent);

    $otherAgent = User::factory()->agent()->create();
    $ticket = Ticket::factory()->agent($otherAgent)->create();

    get(route('tickets.show', $ticket))
        ->assertForbidden();
});
