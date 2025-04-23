<?php

namespace Tests\Feature\Label;

use App\Livewire\Labels\ListLabel;
use App\Models\Label;
use App\Models\User;
use Database\Seeders\PermissionSeeder;

use function Pest\Laravel\seed;
use function Pest\Livewire\livewire;
use function Tests\login;

beforeEach(function () {
    seed(PermissionSeeder::class);
    login();
});

it('can delete a label', function () {
    $label = Label::factory()->create();
    $labelID = $label->id;

    livewire(ListLabel::class)
        ->call('deleteLabel', $label);

    $label = Label::whereId($labelID)->first();
    expect($label)->toBeNull();
});

it('is only allowed to reach this endpoint when logged in as admin', function () {
    login(User::factory()->create());

    $label = Label::factory()->create();

    livewire(ListLabel::class)
        ->call('deleteLabel', $label)
        ->assertForbidden();
});
