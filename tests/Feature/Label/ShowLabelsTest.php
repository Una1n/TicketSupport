<?php

namespace Tests\Feature\Label;

use App\Livewire\Labels\ListLabel;
use App\Models\Label;
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

it('has component on index page', function () {
    get(route('labels.index'))
        ->assertSeeLivewire(ListLabel::class)
        ->assertOk();
});

it('can show a list of labels', function () {
    $labels = Label::factory(3)->create();

    livewire(ListLabel::class)
        ->assertSee([
            ...$labels->pluck('name')->toArray(),
        ]);
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('labels.index'))
        ->assertForbidden();
});
