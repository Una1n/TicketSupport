<?php

use App\Livewire\Users\ListUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

use function Pest\Laravel\assertModelExists;
use function Pest\Laravel\assertModelMissing;

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
    $user = Auth::user();

    Livewire::test(ListUser::class)
        ->call('deleteUser', $user)
        ->assertForbidden();

    assertModelExists($user);
});

it('deletes associated tickets when user is deleted', function () {
    $user = User::factory()->hasTickets(1)->create();
    $ticket = $user->tickets()->first();

    expect($user)->not->toBeNull();
    expect($ticket)->not->toBeNull();

    assertModelExists($ticket);

    $user->delete();

    expect($user->fresh())->toBeNull();
    assertModelMissing($ticket);
});
