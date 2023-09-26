<?php

use App\Livewire\Users\EditUser;
use App\Models\User;
use Spatie\Permission\Models\Role;

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
    $agentRole = Role::whereName('Agent')->first();
    $user = User::factory()->create();

    Livewire::test(EditUser::class, ['user' => $user])
        ->set('name', 'New Name')
        ->set('role', $agentRole->id)
        ->call('save');

    $user->refresh();

    expect($user->name)->toEqual('New Name');
    expect($user->roles)->toHaveCount(1);
    expect($user->roles->first()->name)->toEqual('Agent');
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
    'role' => ['role', ''],
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
        ->call('save')
        ->assertForbidden();
});
