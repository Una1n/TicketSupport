<?php

namespace Tests\Feature\Category;

use App\Livewire\Categories\CreateCategory;
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

it('has component on create page', function () {
    get(route('categories.create'))
        ->assertSeeLivewire(CreateCategory::class)
        ->assertOk();
});

it('can create a new category', function () {
    livewire(CreateCategory::class)
        ->set('form.name', 'Test Name')
        ->call('save');

    $category = Category::whereName('Test Name')->first();
    expect($category)->not->toBeNull();
});

it('validates name is required', function () {
    livewire(CreateCategory::class)
        ->set('form.name', '')
        ->call('save')
        ->assertHasErrors('form.name');
});

it('validates name is unique', function () {
    Category::factory()->create(['name' => 'not unique']);

    livewire(CreateCategory::class)
        ->set('form.name', 'not unique')
        ->call('save')
        ->assertHasErrors('form.name');
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('categories.create'))
        ->assertForbidden();

    livewire(CreateCategory::class)
        ->set('form.name', 'test')
        ->call('save')
        ->assertForbidden();
});
