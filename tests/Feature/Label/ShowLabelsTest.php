<?php

use App\Livewire\Labels\ListLabel;
use App\Models\Label;
use App\Models\User;
use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on index page', function () {
    get(route('labels.index'))
        ->assertSeeLivewire(ListLabel::class)
        ->assertOk();
});

it('can show a list of labels', function () {
    $labels = Label::factory(3)->create();

    Livewire::test(ListLabel::class)
        ->assertSee($labels[0]->name)
        ->assertSee($labels[1]->name)
        ->assertSee($labels[2]->name);
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    get(route('labels.index'))
        ->assertForbidden();
});
