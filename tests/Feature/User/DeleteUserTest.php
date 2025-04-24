<?php

namespace Tests\Feature\User;

use App\Livewire\Users\ListUser;
use App\Models\User;
use Database\Seeders\PermissionSeeder;

use function Pest\Laravel\assertModelExists;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\seed;
use function Pest\Livewire\livewire;
use function Tests\login;

beforeEach(function () {
    seed(PermissionSeeder::class);
    login();
});

it('can delete a user', function () {
    $user = User::factory()->create();

    livewire(ListUser::class)
        ->call('deleteUser', $user);

    assertModelMissing($user);
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    $user = User::factory()->create();

    livewire(ListUser::class)
        ->call('deleteUser', $user)
        ->assertForbidden();
});

it('authenticated user cannot delete their own account', function () {
    $user = auth()->user();

    livewire(ListUser::class)
        ->call('deleteUser', $user)
        ->assertForbidden();

    assertModelExists($user);
});

it('deletes associated tickets when user is deleted', function () {
    $user = User::factory()->hasTickets(1)->create();
    $ticket = $user->tickets()->first();

    expect($user)->not->toBeNull();
    expect($ticket)->not->toBeNull();

    $user->delete();

    assertModelMissing($user);
    assertModelMissing($ticket);
});
