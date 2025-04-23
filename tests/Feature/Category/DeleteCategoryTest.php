<?php

namespace Tests\Feature\Category;

use App\Livewire\Categories\ListCategory;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\PermissionSeeder;

use function Pest\Laravel\seed;
use function Pest\Livewire\livewire;
use function Tests\login;

beforeEach(function () {
    seed(PermissionSeeder::class);
    login();
});

it('can delete a category', function () {
    $category = Category::factory()->create();
    $categoryID = $category->id;

    livewire(ListCategory::class)
        ->call('deleteCategory', $category);

    $category = Category::whereId($categoryID)->first();
    expect($category)->toBeNull();
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    $category = Category::factory()->create();

    livewire(ListCategory::class)
        ->call('deleteCategory', $category)
        ->assertForbidden();
});
