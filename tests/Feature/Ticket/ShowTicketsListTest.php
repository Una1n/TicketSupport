<?php

namespace Tests\Feature\Ticket;

use App\Livewire\Tickets\ListTicket;
use App\Models\Category;
use App\Models\Ticket;
use Database\Seeders\PermissionSeeder;
use Str;

use function Pest\Laravel\get;
use function Pest\Laravel\seed;
use function Pest\Livewire\livewire;
use function Tests\login;

beforeEach(function () {
    seed(PermissionSeeder::class);
    login();
});

it('has component on index page', function () {
    get(route('tickets.index'))
        ->assertSeeLivewire(ListTicket::class)
        ->assertOk();
});

it('can show a list of tickets', function () {
    $tickets = Ticket::factory(3)->create();

    livewire(ListTicket::class)
        ->assertSee([
            ...$tickets->pluck('title')->capitalize()->toArray(),
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

    livewire(ListTicket::class)
        ->set('priorityFilter', 'low')
        ->assertViewHas('tickets', function ($tickets) {
            return $tickets->count() === 4;
        })
        ->assertSee([
            ...$ticketsLow->pluck('title')->capitalize()->toArray(),
        ])
        ->assertDontSee(Str::ucfirst($ticketsMedium->first()->title))
        ->assertDontSee(Str::ucfirst($ticketsHigh->first()->title));
});

it('can show a list of tickets filtered by status', function () {
    $ticketsOpen = Ticket::factory(4)->create([
        'status' => 'open',
    ]);

    $ticketsClosed = Ticket::factory(3)->create([
        'status' => 'closed',
    ]);

    livewire(ListTicket::class)
        ->set('statusFilter', 'open')
        ->assertViewHas('tickets', function ($tickets) {
            return $tickets->count() === 4;
        })
        ->assertSee([
            ...$ticketsOpen->pluck('title')->capitalize()->toArray(),
        ])
        ->assertDontSee([
            ...$ticketsClosed->pluck('title')->capitalize()->toArray(),
        ]);
});

it('can show a list of tickets filtered by category', function () {
    $paymentCategory = Category::whereName('Payment')->first();
    $ticketsWithPaymentCategory = Ticket::factory(4)->categories([$paymentCategory])->create();

    $shippingCategory = Category::whereName('Shipping')->first();
    $ticketsWithOtherCategory = Ticket::factory(3)->categories([$shippingCategory])->create();

    livewire(ListTicket::class)
        ->set('categoryFilter', $paymentCategory->id)
        ->assertViewHas('tickets', function ($tickets) {
            return $tickets->count() === 4;
        })
        ->assertSee([
            ...$ticketsWithPaymentCategory->pluck('title')->capitalize()->toArray(),
        ])
        ->assertDontSee([
            ...$ticketsWithOtherCategory->pluck('title')->capitalize()->toArray(),
        ]);
});

it('can show a list of tickets filtered by search', function () {
    $ticketsToSearch = Ticket::factory(4)->create([
        'title' => 'title to search for',
    ]);

    $ticketsNotInSearch = Ticket::factory(3)->create();

    livewire(ListTicket::class)
        ->set('search', 'title')
        ->assertViewHas('tickets', function ($tickets) {
            return $tickets->count() === 4;
        })
        ->assertSee([
            ...$ticketsToSearch->pluck('title')->capitalize()->toArray(),
        ])
        ->assertDontSee([
            ...$ticketsNotInSearch->pluck('title')->capitalize()->toArray(),
        ]);
});

it('is only allowed to reach this endpoint when logged in', function () {
    auth()->logout();

    get(route('tickets.index'))
        ->assertRedirectToRoute('login');
});
