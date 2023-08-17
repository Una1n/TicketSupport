<?php

use App\Livewire\ActivityLogs\ListLog;
use App\Models\Ticket;
use App\Models\User;
use function Pest\Laravel\get;
use Spatie\Activitylog\Models\Activity;

beforeEach(function () {
    login();
});

it('has component on index page', function () {
    get(route('logs.index'))
        ->assertSeeLivewire(ListLog::class)
        ->assertOk();
});

it('can show a list of logs', function () {
    $tickets = Ticket::factory(3)->create();

    $logs = Activity::where('subject_type', '=', Ticket::class)
        ->whereIn('subject_id', $tickets->pluck('id'))
        ->get();

    Livewire::test(ListLog::class)
        ->assertSee($tickets[0]->title)
        ->assertSee($logs[0]->description)
        ->assertSee($logs[0]->created_at->diffForHumans())
        ->assertSee($tickets[1]->title)
        ->assertSee($logs[1]->description)
        ->assertSee($logs[1]->created_at->diffForHumans())
        ->assertSee($tickets[2]->title)
        ->assertSee($logs[2]->description)
        ->assertSee($logs[2]->created_at->diffForHumans());
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('logs.index'))
        ->assertForbidden();
});
