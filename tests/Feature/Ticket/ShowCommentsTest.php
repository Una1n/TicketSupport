<?php

namespace Tests\Feature\Ticket;

use App\Livewire\Comments\ShowComments;
use App\Models\Comment;
use App\Models\Ticket;
use Database\Seeders\PermissionSeeder;

use function Pest\Laravel\get;
use function Pest\Laravel\seed;
use function Pest\Livewire\livewire;
use function Tests\login;

beforeEach(function () {
    seed(PermissionSeeder::class);
    login();
});

it('has component on show ticket page', function () {
    $ticket = Ticket::factory()->create();

    get(route('tickets.show', $ticket))
        ->assertSeeLivewire(ShowComments::class);
});

it('can show comments for a ticket', function () {
    $ticket = Ticket::factory()->create();
    $comments = Comment::factory(5)->create([
        'ticket_id' => $ticket->id,
    ]);

    livewire(ShowComments::class, ['ticket' => $ticket])
        ->assertSee([
            ...$comments->pluck('message')->toArray(),
        ]);
});
