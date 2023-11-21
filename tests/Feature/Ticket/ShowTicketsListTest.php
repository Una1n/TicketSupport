<?php

use App\Livewire\Tickets\ListTicket;
use App\Models\Category;
use App\Models\Ticket;

use function Pest\Laravel\get;

beforeEach(function () {
    login();
});

it('has component on index page', function () {
    get(route('tickets.index'))
        ->assertSeeLivewire(ListTicket::class)
        ->assertOk();
});

it('can show a list of tickets', function () {
    $tickets = Ticket::factory(3)->create();

    Livewire::test(ListTicket::class)
        ->assertSee([
            ...$tickets->pluck('title')->toArray(),
        ]);
});

it('can show a list of tickets filtered by priority', function () {
    $ticketsLow = Ticket::factory(4)->create([
        'priority' => 'low',
    ]);

    $ticketsMedium = Ticket::factory(3)->create([
        'priority' => 'medium',
    ]);

    $ticketsHigh = Ticket::factory(1)->create([
        'priority' => 'high',
    ]);

    Livewire::test(ListTicket::class)
        ->set('priorityFilter', 'low')
        ->assertViewHas('tickets', function ($tickets) {
            return $tickets->count() === 4;
        })
        ->assertSee([
            ...$ticketsLow->pluck('title')->toArray(),
        ])
        ->assertDontSee($ticketsMedium->first()->title)
        ->assertDontSee($ticketsHigh->first()->title);
});

it('can show a list of tickets filtered by status', function () {
    $ticketsOpen = Ticket::factory(4)->create([
        'status' => 'open',
    ]);

    $ticketsClosed = Ticket::factory(3)->create([
        'status' => 'closed',
    ]);

    Livewire::test(ListTicket::class)
        ->set('statusFilter', 'open')
        ->assertViewHas('tickets', function ($tickets) {
            return $tickets->count() === 4;
        })
        ->assertSee([
            ...$ticketsOpen->pluck('title')->toArray(),
        ])
        ->assertDontSee([
            ...$ticketsClosed->pluck('title')->toArray(),
        ]);
});

it('can show a list of tickets filtered by category', function () {
    $paymentCategory = Category::whereName('Payment')->first();
    $ticketsWithPaymentCategory = Ticket::factory(4)->create();
    foreach ($ticketsWithPaymentCategory as $ticket) {
        $ticket->categories()->attach($paymentCategory->id);
    }

    $shippingCategory = Category::whereName('Shipping')->first();
    $ticketsWithOtherCategory = Ticket::factory(3)->create();
    foreach ($ticketsWithOtherCategory as $ticket) {
        $ticket->categories()->attach($shippingCategory->id);
    }

    Livewire::test(ListTicket::class)
        ->set('categoryFilter', $paymentCategory->id)
        ->assertViewHas('tickets', function ($tickets) {
            return $tickets->count() === 4;
        })
        ->assertSee([
            ...$ticketsWithPaymentCategory->pluck('title')->toArray(),
        ])
        ->assertDontSee([
            ...$ticketsWithOtherCategory->pluck('title')->toArray(),
        ]);
});

it('can show a list of tickets filtered by search', function () {
    $ticketsToSearch = Ticket::factory(4)->create([
        'title' => 'title to search for',
    ]);

    $ticketsNotInSearch = Ticket::factory(3)->create();

    Livewire::test(ListTicket::class)
        ->set('search', 'title')
        ->assertViewHas('tickets', function ($tickets) {
            return $tickets->count() === 4;
        })
        ->assertSee([
            ...$ticketsToSearch->pluck('title')->toArray(),
        ])
        ->assertDontSee([
            ...$ticketsNotInSearch->pluck('title')->toArray(),
        ]);
});

it('is only allowed to reach this endpoint when logged in', function () {
    Auth::logout();

    get(route('tickets.index'))
        ->assertRedirectToRoute('login');
});
