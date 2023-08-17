<?php

use App\Livewire\ActivityLogs\ShowLog;
use App\Models\Ticket;
use function Pest\Laravel\get;
use Spatie\Activitylog\Models\Activity;

beforeEach(function () {
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

    $log = Activity::where('subject_type', '=', Ticket::class)
        ->where('subject_id', '=', $ticket->id)
        ->first();

    Livewire::test(ShowLog::class, ['log' => $log])
        ->assertSee(ucfirst($ticket->title))
        ->assertSee(ucfirst($log->description))
        ->assertSee($log->created_at->diffForHumans())
        ->assertSee(json_encode(json_decode($log->changes, true), JSON_PRETTY_PRINT));
});
