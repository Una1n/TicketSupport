<?php

use App\Livewire\Comments\ShowComments;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Spatie\Permission\Models\Role;

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
    expect($ticket->comments->first()->message)->toEqual('Test Message for comment');
    expect($ticket->comments->first()->user_id)->toEqual(auth()->user()->id);
});

it('validates required message field', function () {
    $ticket = Ticket::factory()->create();

    Livewire::test(ShowComments::class, ['ticket' => $ticket])
        ->set('newComment', '')
        ->call('save')
        ->assertHasErrors('newComment');
});

it('is not allowed to add comments when not logged in', function () {
    Auth::logout();

    $ticket = Ticket::factory()->create();

    Livewire::test(ShowComments::class, ['ticket' => $ticket])
        ->set('newComment', 'Test Message for comment')
        ->call('save')
        ->assertForbidden();
});

it('is allowed to add comments when logged in as regular user', function () {
    $user = User::factory()->create();
    $role = Role::whereName('Regular')->first();
    $user->assignRole($role);
    login($user);

    $ticket = Ticket::factory()->create();

    Livewire::test(ShowComments::class, ['ticket' => $ticket])
        ->set('newComment', 'Test Message for comment')
        ->call('save')
        ->assertStatus(200);

    $comment = Comment::whereTicketId($ticket->id)->first();
    expect($comment)->not->toBeNull();
    expect($comment->message)->toEqual('Test Message for comment');
});
