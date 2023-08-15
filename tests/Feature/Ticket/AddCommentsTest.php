<?php

use App\Livewire\Comments\ShowComments;
use App\Models\Ticket;
use Illuminate\Auth\Access\AuthorizationException;

beforeEach(function () {
    login();
});

it('can create a new comment', function () {
    $ticket = Ticket::factory()->create();

    Livewire::test(ShowComments::class, ['ticket' => $ticket])
        ->set('newComment', 'Test Message for comment')
        ->call('save');

    $ticket->refresh();

    expect($ticket->comments)->not->toBeNull();
    expect($ticket->comments)->toHaveCount(1);
    expect($ticket->comments[0]->message)->toEqual('Test Message for comment');
    expect($ticket->comments[0]->user_id)->toEqual(auth()->user()->id);
});

it('validates required message field', function () {
    $ticket = Ticket::factory()->create();

    Livewire::test(ShowComments::class, ['ticket' => $ticket])
        ->set('newComment', '')
        ->call('save')
        ->assertHasErrors('newComment');
});

it('is only allowed to add comments when logged in', function () {
    Auth::logout();

    $ticket = Ticket::factory()->create();

    // TODO: ->assertUnauthorized()/->assertForbidden()/->assertStatus()
    // these functions don't work, but we can get around it by catching it with pest
    Livewire::test(ShowComments::class, ['ticket' => $ticket])
        ->set('newComment', 'Test Message for comment')
        ->call('save');

})->throws(AuthorizationException::class, 'This action is unauthorized.');
