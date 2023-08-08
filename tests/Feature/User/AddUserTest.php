<?php

use App\Livewire\Users\CreateUser;
use App\Models\User;
use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on create page', function () {
    get(route('users.create'))
        ->assertSeeLivewire(CreateUser::class)
        ->assertOk();
});

it('can create a new user', function () {
    Livewire::test(CreateUser::class)
        ->set('name', 'Henk Stubbe')
        ->set('email', 'henk@stubbe.nl')
        ->set('password', 'password')
        ->call('save');

    $user = User::whereName('Henk Stubbe')->first();
    expect($user)->not->toBeNull();
});

it('validates required fields', function (string $name, string $value) {
    Livewire::test(CreateUser::class)
        ->set($name, $value)
        ->call('save')
        ->assertHasErrors($name);
})->with([
    'name' => ['name', ''],
    'email' => ['email', ''],
    'password' => ['password', ''],
]);

it('validates email is unique', function () {
    User::factory()->create(['email' => 'test@unique.com']);

    Livewire::test(CreateUser::class)
        ->set('name', 'Harry Stevens')
        ->set('email', 'test@unique.com')
        ->set('password', 'password')
        ->call('save')
        ->assertHasErrors('email');
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    // TODO: Not working yet on livewire 3 beta 7
    // Livewire::test(CreateUser::class)
    //     ->set('name', 'Henk Stubbe')
    //     ->set('email', 'henk@stubbe.nl')
    //     ->set('password', 'password')
    //     ->call('save')
    //     ->assertForbidden();

    get(route('users.create'))
        ->assertForbidden();
});
