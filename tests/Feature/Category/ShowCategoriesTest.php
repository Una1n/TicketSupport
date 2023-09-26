<?php

use App\Livewire\Categories\ListCategory;
use App\Models\Category;
use App\Models\User;

use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on index page', function () {
    get(route('categories.index'))
        ->assertSeeLivewire(ListCategory::class)
        ->assertOk();
});

it('can show a list of categories', function () {
    $categories = Category::factory(3)->create();

    Livewire::test(ListCategory::class)
        ->assertSee([
            ...$categories->pluck('name')->toArray(),
        ]);
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('categories.index'))
        ->assertForbidden();
});
