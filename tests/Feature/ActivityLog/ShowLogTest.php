<?php

namespace Tests\Feature\ActivityLog;

use App\Livewire\ActivityLogs\ShowLog;
use App\Models\Ticket;
use Database\Seeders\PermissionSeeder;
use Spatie\Activitylog\Models\Activity;

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

    get(route('logs.show', $ticket))
        ->assertSeeLivewire(ShowLog::class)
        ->assertOk();
});

it('can show a log', function () {
    $ticket = Ticket::factory()->create();

    $log = Activity::whereSubjectType(Ticket::class)
        ->whereSubjectId($ticket->id)
        ->first();

    livewire(ShowLog::class, ['log' => $log])
        ->assertSee(ucfirst($ticket->title))
        ->assertSee(ucfirst($log->description))
        ->assertSee($log->created_at->diffForHumans())
        ->assertSee(json_encode(json_decode($log->changes, true), JSON_PRETTY_PRINT));
});
