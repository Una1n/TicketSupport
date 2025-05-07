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
    $role = Role::whereName('Regular')->first();

    livewire(CreateUser::class)
        ->set('form.name', 'Henk Stubbe')
        ->set('form.email', 'henk@stubbe.nl')
        ->set('form.password', 'password')
        ->set('form.role', $role->id)
        ->call('save');

    $user = User::whereName('Henk Stubbe')->first();
    expect($user)->not->toBeNull();
    expect($user->roles)->toHaveCount(1);
    expect($user->roles->first()->name)->toBe('Regular');
});

it('validates required fields', function (string $name, string $value) {
    livewire(CreateUser::class)
        ->set($name, $value)
        ->call('save')
        ->assertHasErrors($name);
})->with([
    'form.name' => ['name', ''],
    'form.email' => ['email', ''],
    'form.password' => ['password', ''],
    'form.role' => ['role', ''],
]);

it('validates email is unique', function () {
    User::factory()->create(['email' => 'test@unique.com']);

    livewire(CreateUser::class)
        ->set('form.name', 'Harry Stevens')
        ->set('form.email', 'test@unique.com')
        ->set('form.password', 'password')
        ->call('save')
        ->assertHasErrors('form.email');
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('users.create'))
        ->assertForbidden();

    livewire(CreateUser::class)
        ->set('form.name', 'Henk Stubbe')
        ->set('form.email', 'henk@stubbe.nl')
        ->set('form.password', 'password')
        ->call('save')
        ->assertForbidden();
});
