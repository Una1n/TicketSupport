<?php

namespace Tests\Feature\Label;

use App\Livewire\Labels\EditLabel;
use App\Livewire\Labels\ListLabel;
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

it('has visible edit component on index page', function () {
    $label = Label::factory()->create();

    get(route('labels.index'))
        ->assertSee($label->name)
        ->assertSeeHtml('openEditModal')
        ->assertOk();
});

it('has functioning edit modal on index page', function () {
    $label = Label::factory()->create();

    livewire(ListLabel::class)
        ->call('openEditModal', $label)
        ->assertSeeHtml('dialog');
});

it('can edit a category', function () {
    $label = Label::factory()->create();

    livewire(EditLabel::class, ['label' => $label])
        ->set('form.name', 'New Name')
        ->call('save');

    $label->refresh();

    expect($label->name)->toEqual('New Name');
});

it('validates name is required', function () {
    $label = Label::factory()->create();

    livewire(EditLabel::class, ['label' => $label])
        ->set('form.name', '')
        ->call('save')
        ->assertHasErrors('form.name');
});

it('validates name is unique', function () {
    Label::factory()->create(['name' => 'test']);
    $label = Label::factory()->create(['name' => 'labelname']);

    livewire(EditLabel::class, ['label' => $label])
        ->set('form.name', 'test')
        ->call('save')
        ->assertHasErrors('form.name');
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    $label = Label::factory()->create();

    get(route('labels.index'))
        ->assertForbidden();

    livewire(EditLabel::class, ['label' => $label])
        ->set('form.name', 'test')
        ->call('save')
        ->assertForbidden();
});
