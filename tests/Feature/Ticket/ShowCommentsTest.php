<?php

use App\Livewire\Comments\ShowComments;
use App\Models\Comment;
use App\Models\Ticket;
use function Pest\Laravel\get;

beforeEach(function () {
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

    Livewire::test(ShowComments::class, ['ticket' => $ticket])
        ->assertSee($comments[0]->message)
        ->assertSee($comments[1]->message)
        ->assertSee($comments[2]->message)
        ->assertSee($comments[3]->message)
        ->assertSee($comments[4]->message);
});
