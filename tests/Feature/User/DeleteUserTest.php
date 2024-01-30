<?php

use App\Livewire\Users\ListUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
    $user = Auth::user();

    Livewire::test(ListUser::class)
        ->call('deleteUser', $user)
        ->assertForbidden();

    // Check user
    $this->assertDatabaseHas('users', ['id' => $user->id]);
});

it('deletes associated tickets when user is deleted', function () {
    $user = User::factory()->hasTickets(1)->create();
    $ticketID = $user->tickets()->first()->id;

    expect(User::find($user->id))->not->toBeNull();
    expect($ticketID)->not->toBeNull();

    $this->assertDatabaseHas('tickets', ['id' => $ticketID]);

    User::find($user->id)->delete();

    expect(User::find($user->id))->toBeNull();
   $this->assertDatabaseMissing('tickets', ['id' => $ticketID]);
});
