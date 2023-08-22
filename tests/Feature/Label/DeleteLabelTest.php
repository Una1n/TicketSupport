<?php

use App\Livewire\Labels\ListLabel;
use App\Models\Label;
use App\Models\User;

beforeEach(function () {
    login();
});

it('can delete a label', function () {
    $label = Label::factory()->create();
    $labelID = $label->id;

    Livewire::test(ListLabel::class)
        ->call('deleteLabel', $label);

    $label = Label::whereId($labelID)->first();
    expect($label)->toBeNull();
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    $label = Label::factory()->create();

    Livewire::test(ListLabel::class)
        ->call('deleteLabel', $label)
        ->assertForbidden();
});
