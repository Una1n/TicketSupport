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
        ->assertSee($tickets[0]->title)
        ->assertSee($tickets[1]->title)
        ->assertSee($tickets[2]->title);
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
            if ($tickets->count() === 4) {
                return true;
            }

            return false;
            // TODO: Expectation/Assertion is not working
            // expect($tickets)->toHaveCount(4);
            // $this->assertCount(4, $tickets);
        })
        ->assertSee($ticketsLow[0]->title)
        ->assertSee($ticketsLow[1]->title)
        ->assertSee($ticketsLow[2]->title)
        ->assertSee($ticketsLow[3]->title)
        ->assertDontSee($ticketsMedium[0]->title)
        ->assertDontSee($ticketsHigh[0]->title);
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
            if ($tickets->count() === 4) {
                return true;
            }

            return false;
            // TODO: Expectation/Assertion is not working
            // expect($tickets)->toHaveCount(4);
            // $this->assertCount(4, $tickets);
        })
        ->assertSee($ticketsOpen[0]->title)
        ->assertSee($ticketsOpen[1]->title)
        ->assertSee($ticketsOpen[2]->title)
        ->assertSee($ticketsOpen[3]->title)
        ->assertDontSee($ticketsClosed[0]->title)
        ->assertDontSee($ticketsClosed[1]->title)
        ->assertDontSee($ticketsClosed[2]->title);
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
            if ($tickets->count() === 4) {
                return true;
            }

            return false;
            // TODO: Expectation/Assertion is not working
            // expect($tickets)->toHaveCount(4);
            // $this->assertCount(4, $tickets);
        })
        ->assertSee($ticketsWithPaymentCategory[0]->title)
        ->assertSee($ticketsWithPaymentCategory[1]->title)
        ->assertSee($ticketsWithPaymentCategory[2]->title)
        ->assertSee($ticketsWithPaymentCategory[3]->title)
        ->assertDontSee($ticketsWithOtherCategory[0]->title)
        ->assertDontSee($ticketsWithOtherCategory[1]->title)
        ->assertDontSee($ticketsWithOtherCategory[2]->title);
});

it('can show a list of tickets filtered by search', function () {
    $ticketsToSearch = Ticket::factory(4)->create([
        'title' => 'title to search for',
    ]);

    $ticketsNotInSearch = Ticket::factory(3)->create();

    Livewire::test(ListTicket::class)
        ->set('search', 'title')
        ->assertViewHas('tickets', function ($tickets) {
            if ($tickets->count() === 4) {
                return true;
            }

            return false;
            // TODO: Expectation/Assertion is not working
            // expect($tickets)->toHaveCount(4);
            // $this->assertCount(4, $tickets);
        })
        ->assertSee($ticketsToSearch[0]->title)
        ->assertSee($ticketsToSearch[1]->title)
        ->assertSee($ticketsToSearch[2]->title)
        ->assertSee($ticketsToSearch[3]->title)
        ->assertDontSee($ticketsNotInSearch[0]->title)
        ->assertDontSee($ticketsNotInSearch[1]->title)
        ->assertDontSee($ticketsNotInSearch[2]->title);
});

it('is only allowed to reach this endpoint when logged in', function () {
    Auth::logout();

    get(route('tickets.index'))
        ->assertRedirectToRoute('login');
});
