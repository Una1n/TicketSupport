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

    $category = Label::factory()->create();

    // TODO: Not working yet on livewire 3 beta 7
    // Livewire::test(ListLabel::class)
    //     ->call('deleteLabel', $category)
    //     ->assertForbidden();
})->todo();
