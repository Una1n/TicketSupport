<?php

namespace Tests\Feature\Label;

use App\Livewire\Labels\CreateLabel;
use App\Models\Label;
use App\Models\User;
use Database\Seeders\PermissionSeeder;

use function Pest\Laravel\get;
use function Pest\Laravel\seed;
use function Pest\Livewire\livewire;
use function Tests\login;

beforeEach(function () {
    seed(PermissionSeeder::class);
    login();
});

it('has component on create page', function () {
    get(route('labels.create'))
        ->assertSeeLivewire(CreateLabel::class)
        ->assertOk();
});

it('can create a new label', function () {
    livewire(CreateLabel::class)
        ->set('name', 'Test Name')
        ->call('save');

    $label = Label::whereName('Test Name')->first();
    expect($label)->not->toBeNull();
});

it('validates name is required', function () {
    livewire(CreateLabel::class)
        ->set('name', '')
        ->call('save')
        ->assertHasErrors('name');
});

it('validates name is unique', function () {
    Label::factory()->create(['name' => 'not unique']);

    livewire(CreateLabel::class)
        ->set('name', 'not unique')
        ->call('save')
        ->assertHasErrors('name');
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('labels.create'))
        ->assertForbidden();

    livewire(CreateLabel::class)
        ->set('name', 'test')
        ->call('save')
        ->assertForbidden();
});
