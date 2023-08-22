<?php

use App\Livewire\Labels\EditLabel;
use App\Models\Label;
use App\Models\User;

use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on edit page', function () {
    $label = Label::factory()->create();

    get(route('labels.edit', $label))
        ->assertSeeLivewire(EditLabel::class)
        ->assertOk();
});

it('can edit a category', function () {
    $label = Label::factory()->create();

    Livewire::test(EditLabel::class, ['label' => $label])
        ->set('name', 'New Name')
        ->call('save');

    $label->refresh();

    expect($label->name)->toEqual('New Name');
});

it('validates name is required', function () {
    $label = Label::factory()->create();

    Livewire::test(EditLabel::class, ['label' => $label])
        ->set('name', '')
        ->call('save')
        ->assertHasErrors('name');
});

it('validates name is unique', function () {
    Label::factory()->create(['name' => 'test']);
    $label = Label::factory()->create(['name' => 'labelname']);

    Livewire::test(EditLabel::class, ['label' => $label])
        ->set('name', 'test')
        ->call('save')
        ->assertHasErrors('name');
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    $label = Label::factory()->create();

    get(route('labels.edit', $label))
        ->assertForbidden();

    Livewire::test(EditLabel::class, ['label' => $label])
        ->set('name', 'test')
        ->call('save')
        ->assertForbidden();
});
