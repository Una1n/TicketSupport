<?php

use App\Livewire\Categories\ListCategory;
use App\Models\Category;
use App\Models\User;

beforeEach(function () {
    login();
});

it('can delete a category', function () {
    $category = Category::factory()->create();
    $categoryID = $category->id;

    Livewire::test(ListCategory::class)
        ->call('deleteCategory', $category);

    $category = Category::whereId($categoryID)->first();
    expect($category)->toBeNull();
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    $category = Category::factory()->create();

    Livewire::test(ListCategory::class)
        ->call('deleteCategory', $category)
        ->assertForbidden();
});
