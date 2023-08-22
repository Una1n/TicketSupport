<?php

use App\Livewire\Categories\CreateCategory;
use App\Models\Category;
use App\Models\User;

use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on create page', function () {
    get(route('categories.create'))
        ->assertSeeLivewire(CreateCategory::class)
        ->assertOk();
});

it('can create a new category', function () {
    Livewire::test(CreateCategory::class)
        ->set('name', 'Test Name')
        ->call('save');

    $category = Category::whereName('Test Name')->first();
    expect($category)->not->toBeNull();
});

it('validates name is required', function () {
    Livewire::test(CreateCategory::class)
        ->set('name', '')
        ->call('save')
        ->assertHasErrors('name');
});

it('validates name is unique', function () {
    Category::factory()->create(['name' => 'not unique']);

    Livewire::test(CreateCategory::class)
        ->set('name', 'not unique')
        ->call('save')
        ->assertHasErrors('name');
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('categories.create'))
        ->assertForbidden();

    Livewire::test(CreateCategory::class)
        ->set('name', 'test')
        ->call('save')
        ->assertForbidden();
});
