<?php

namespace Tests\Feature\Category;

use App\Livewire\Categories\ListCategory;
use App\Models\Category;
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
    get(route('categories.index'))
        ->assertSeeLivewire(ListCategory::class)
        ->assertOk();
});

it('can show a list of categories', function () {
    $categories = Category::factory(3)->create();

    livewire(ListCategory::class)
        ->assertSee([
            ...$categories->pluck('name')->toArray(),
        ]);
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('categories.index'))
        ->assertForbidden();
});
