<?php

use App\Livewire\Tickets\CreateTicket;
use App\Models\Ticket;
use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on create page', function () {
    get(route('tickets.create'))
        ->assertSeeLivewire(CreateTicket::class)
        ->assertOk();
});

it('can create a new ticket', function () {
    Livewire::test(CreateTicket::class)
        ->set('form.title', 'Test Title')
        ->set('form.priority', 'low')
        ->set('form.description', 'This is a test description for ticket')
        ->call('save');

    $ticket = Ticket::whereTitle('Test Title')->first();
    expect($ticket)->not->toBeNull();
    expect($ticket->priority)->toEqual('low');
    expect($ticket->status)->toEqual('open');
    expect($ticket->description)->toEqual('This is a test description for ticket');
    expect($ticket->user->name)->toEqual('Jerry');
});

it('validates required fields', function (string $name, string $value) {
    Livewire::test(CreateTicket::class)
        ->set($name, $value)
        ->call('save')
        ->assertHasErrors($name);
})->with([
    'title' => ['form.title', ''],
    'priority' => ['form.priority', ''],
    'description' => ['form.description', ''],
]);

it('is only allowed to reach this endpoint when logged in', function () {
    Auth::logout();

    // TODO: Not working yet on livewire 3 beta 8
    // Livewire::test(CreateTicket::class)
    //     ->set('form.title', 'Test Title')
    //     ->set('form.priority', 'low')
    //     ->set('form.description', 'This is a test description for ticket')
    //     ->call('save');
    //     ->assertForbidden();

    get(route('tickets.create'))
        ->assertRedirectToRoute('login');
});
