<?php

namespace Tests\Feature\Category;

use App\Livewire\Categories\EditCategory;
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

it('has visible edit component on index page', function () {
    $category = Category::factory()->create();

    get(route('categories.index'))
        ->assertSee($category->name)
        ->assertSeeHtml('openEditModal')
        ->assertOk();
});

it('has functioning edit modal on index page', function () {
    $category = Category::factory()->create();

    livewire(ListCategory::class)
        ->call('openEditModal', $category)
        ->assertSeeHtml('dialog');
});

it('can edit a category', function () {
    $category = Category::factory()->create();

    livewire(EditCategory::class, ['category' => $category])
        ->set('form.name', 'New Name')
        ->call('save');

    $category->refresh();

    expect($category->name)->toEqual('New Name');
});

it('validates name is required', function () {
    $category = Category::factory()->create();

    livewire(EditCategory::class, ['category' => $category])
        ->set('form.name', '')
        ->call('save')
        ->assertHasErrors('form.name');
});

it('validates name is unique', function () {
    Category::factory()->create(['name' => 'test']);
    $category = Category::factory()->create(['name' => 'categoryname']);

    livewire(EditCategory::class, ['category' => $category])
        ->set('form.name', 'test')
        ->call('save')
        ->assertHasErrors('form.name');
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    $category = Category::factory()->create();

    get(route('categories.index'))
        ->assertForbidden();

    livewire(EditCategory::class, ['category' => $category])
        ->set('form.name', 'test')
        ->call('save')
        ->assertForbidden();
});
