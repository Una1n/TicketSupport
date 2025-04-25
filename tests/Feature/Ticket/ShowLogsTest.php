<?php

namespace Tests\Feature\Ticket;

use App\Livewire\ActivityLogs\ShowLogs;
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
        ->assertSeeLivewire(ShowLogs::class);
});

it('can show a log for the creation of the ticket', function () {
    $ticket = Ticket::factory()->create();

    livewire(ShowLogs::class, ['ticket' => $ticket])
        ->assertSee('Ticket Created');
});

it('can show a log for updating the ticket', function () {
    $ticket = Ticket::factory()->create();

    $ticket->update([
        'title' => 'Updated Title',
    ]);

    livewire(ShowLogs::class, ['ticket' => $ticket])
        ->assertSee('Ticket Updated')
        ->assertSee('Updated Title');
});
