<?php

namespace Tests\Feature\ActivityLog;

use App\Livewire\ActivityLogs\ListLog;
use App\Models\Ticket;
use App\Models\User;
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

    livewire(ListLog::class)
        ->assertSee([
            ...$tickets->pluck('title')->toArray(),
            ...$logs->pluck('description')->toArray(),
            ...$logs->pluck('created_at')
                ->map(fn ($item) => $item->diffForHumans())
                ->toArray(),
        ]);
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('logs.index'))
        ->assertForbidden();
});
