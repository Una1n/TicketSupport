<?php

use App\Livewire\Labels\CreateLabel;
use App\Models\Label;
use App\Models\User;

use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on create page', function () {
    get(route('labels.create'))
        ->assertSeeLivewire(CreateLabel::class)
        ->assertOk();
});

it('can create a new label', function () {
    Livewire::test(CreateLabel::class)
        ->set('name', 'Test Name')
        ->call('save');

    $label = Label::whereName('Test Name')->first();
    expect($label)->not->toBeNull();
});

it('validates name is required', function () {
    Livewire::test(CreateLabel::class)
        ->set('name', '')
        ->call('save')
        ->assertHasErrors('name');
});

it('validates name is unique', function () {
    Label::factory()->create(['name' => 'not unique']);

    Livewire::test(CreateLabel::class)
        ->set('name', 'not unique')
        ->call('save')
        ->assertHasErrors('name');
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('labels.create'))
        ->assertForbidden();

    Livewire::test(CreateLabel::class)
        ->set('name', 'test')
        ->call('save')
        ->assertForbidden();
});
