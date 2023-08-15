<?php

use App\Livewire\ActivityLogs\ShowLogs;
use App\Models\Ticket;
use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on show ticket page', function () {
    $ticket = Ticket::factory()->create();

    get(route('tickets.show', $ticket))
        ->assertSeeLivewire(ShowLogs::class);
});

it('can show a log for the creation of the ticket', function () {
    $ticket = Ticket::factory()->create();

    Livewire::test(ShowLogs::class, ['ticket' => $ticket])
        ->assertSee('Ticket Created');
});

it('can show a log for updating the ticket', function () {
    $ticket = Ticket::factory()->create();

    $ticket->update([
        'title' => 'Updated Title',
    ]);

    Livewire::test(ShowLogs::class, ['ticket' => $ticket])
        ->assertSee('Ticket Updated')
        ->assertSee('Updated Title');
});
