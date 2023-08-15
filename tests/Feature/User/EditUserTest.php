<?php

use App\Livewire\Users\EditUser;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on edit page', function () {
    $user = User::factory()->create();

    get(route('users.edit', $user))
        ->assertSeeLivewire(EditUser::class)
        ->assertOk();
});

it('can edit a user', function () {
    $user = User::factory()->create();

    Livewire::test(EditUser::class, ['user' => $user])
        ->set('name', 'New Name')
        ->call('save');

    $user->refresh();

    expect($user->name)->toEqual('New Name');
});

it('validates required fields', function (string $name, string $value) {
    $user = User::factory()->create();

    Livewire::test(EditUser::class, ['user' => $user])
        ->set($name, $value)
        ->call('save')
        ->assertHasErrors($name);
})->with([
    'name' => ['name', ''],
    'email' => ['email', ''],
]);

it('validates email is unique', function () {
    User::factory()->create(['email' => 'test@unique.com']);
    $user = User::factory()->create(['email' => 'a@b.com']);

    Livewire::test(EditUser::class, ['user' => $user])
        ->set('email', 'test@unique.com')
        ->call('save')
        ->assertHasErrors('email');
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    $user = User::factory()->create();

    get(route('users.edit', $user))
        ->assertForbidden();

    Livewire::test(EditUser::class, ['user' => $user])
        ->set('name', 'test')
        ->call('save');

})->throws(AuthorizationException::class, 'This action is unauthorized.');
