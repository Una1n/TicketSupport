<?php

namespace Tests\Feature\User;

use App\Livewire\Users\CreateUser;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\get;
use function Pest\Laravel\seed;
use function Pest\Livewire\livewire;
use function Tests\login;

beforeEach(function () {
    seed(PermissionSeeder::class);
    login();
});

it('has component on create page', function () {
    get(route('users.create'))
        ->assertSeeLivewire(CreateUser::class)
        ->assertOk();
});

it('can create a new regular user', function () {
    $role = Role::where('name', 'Regular')->first();

    livewire(CreateUser::class)
        ->set('name', 'Henk Stubbe')
        ->set('email', 'henk@stubbe.nl')
        ->set('password', 'password')
        ->set('role', $role->id)
        ->call('save');

    $user = User::where('name', 'Henk Stubbe')->first();
    expect($user)->not->toBeNull();
    expect($user->roles)->toHaveCount(1);
});

it('validates required fields', function (string $name, string $value) {
    livewire(CreateUser::class)
        ->set($name, $value)
        ->call('save')
        ->assertHasErrors($name);
})->with([
    'name' => ['name', ''],
    'email' => ['email', ''],
    'password' => ['password', ''],
    'role' => ['role', ''],
]);

it('validates email is unique', function () {
    User::factory()->create(['email' => 'test@unique.com']);

    livewire(CreateUser::class)
        ->set('name', 'Harry Stevens')
        ->set('email', 'test@unique.com')
        ->set('password', 'password')
        ->call('save')
        ->assertHasErrors('email');
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('users.create'))
        ->assertForbidden();

    livewire(CreateUser::class)
        ->set('name', 'Henk Stubbe')
        ->set('email', 'henk@stubbe.nl')
        ->set('password', 'password')
        ->call('save')
        ->assertForbidden();
});
