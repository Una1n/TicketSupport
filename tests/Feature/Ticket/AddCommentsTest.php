<?php

namespace Tests\Feature\Ticket;

use App\Livewire\Comments\ShowComments;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\PermissionSeeder;

use function Pest\Laravel\seed;
use function Pest\Livewire\livewire;
use function Tests\login;

beforeEach(function () {
    seed(PermissionSeeder::class);
    login();
});

it('can create a new comment', function () {
    $ticket = Ticket::factory()->create();

    livewire(ShowComments::class, ['ticket' => $ticket])
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

    livewire(ShowComments::class, ['ticket' => $ticket])
        ->set('newComment', '')
        ->call('save')
        ->assertHasErrors('newComment');
});

it('is not allowed to add comments when not logged in', function () {
    auth()->logout();

    $ticket = Ticket::factory()->create();

    livewire(ShowComments::class, ['ticket' => $ticket])
        ->set('newComment', 'Test Message for comment')
        ->call('save')
        ->assertForbidden();
});

it('is allowed to add comments when logged in as regular user', function () {
    $user = User::factory()->create();
    login($user);

    $ticket = Ticket::factory()->create();

    livewire(ShowComments::class, ['ticket' => $ticket])
        ->set('newComment', 'Test Message for comment')
        ->call('save')
        ->assertStatus(200);

    $comment = Comment::whereTicketId($ticket->id)->first();
    expect($comment)->not->toBeNull();
    expect($comment->message)->toEqual('Test Message for comment');
});
