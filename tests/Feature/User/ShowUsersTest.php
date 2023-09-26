<?php

use App\Livewire\Users\ListUser;
use App\Models\User;

use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on index page', function () {
    get(route('users.index'))
        ->assertSeeLivewire(ListUser::class)
        ->assertOk();
});

it('can show a list of users', function () {
    $users = User::factory(3)->create();

    Livewire::test(ListUser::class)
        ->assertSee([
            ...$users->pluck('name')->toArray(),
        ]);
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('users.index'))
        ->assertForbidden();
});
