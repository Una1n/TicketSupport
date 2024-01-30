<?php

use App\Livewire\Users\ListUser;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    login();
});

it('can delete a user', function () {
    $user = User::factory()->create();
    $userID = $user->id;

    Livewire::test(ListUser::class)
        ->call('deleteUser', $user);

    $user = User::whereId($userID)->first();
    expect($user)->toBeNull();
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    $user = User::factory()->create();

    Livewire::test(ListUser::class)
        ->call('deleteUser', $user)
        ->assertForbidden();
});

it('authenticated user cannot delete their own account', function () {
    $user = User::factory()->create();
    login($user);

    Livewire::test(ListUser::class)
        ->call('deleteUser', $user)
        ->assertForbidden();
});
