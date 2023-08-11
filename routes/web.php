<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Categories\CreateCategory;
use App\Livewire\Categories\EditCategory;
use App\Livewire\Categories\ListCategory;
use App\Livewire\DashboardHome;
use App\Livewire\Labels\CreateLabel;
use App\Livewire\Labels\EditLabel;
use App\Livewire\Labels\ListLabel;
use App\Livewire\Tickets\CreateTicket;
use App\Livewire\Tickets\ListTicket;
use App\Livewire\Tickets\ShowTicket;
use App\Livewire\Users\CreateUser;
use App\Livewire\Users\EditUser;
use App\Livewire\Users\ListUser;
use App\Models\Category;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardHome::class)->name('dashboard');

    Route::middleware('can:manage,' . Category::class)
        ->prefix('categories')
        ->as('categories.')
        ->group(function () {
            Route::get('/', ListCategory::class)->name('index');
            Route::get('/create', CreateCategory::class)->name('create');
            Route::get('/{category}/edit', EditCategory::class)->name('edit');
        });

    Route::middleware('can:manage,' . Label::class)
        ->prefix('labels')
        ->as('labels.')
        ->group(function () {
            Route::get('/', ListLabel::class)->name('index');
            Route::get('/create', CreateLabel::class)->name('create');
            Route::get('/{label}/edit', EditLabel::class)->name('edit');
        });

    Route::middleware('can:manage,' . User::class)
        ->prefix('users')
        ->as('users.')
        ->group(function () {
            Route::get('/', ListUser::class)->name('index');
            Route::get('/create', CreateUser::class)->name('create');
            Route::get('/{user}/edit', EditUser::class)->name('edit');
        });

    Route::prefix('tickets')->as('tickets.')->group(function () {
        Route::get('/', ListTicket::class)->name('index')
            ->can('viewList', Ticket::class);

        Route::get('/{ticket}/show', ShowTicket::class)->name('show')
            ->can('view', Ticket::class);

        Route::get('/create', CreateTicket::class)->name('create')
            ->can('create', Ticket::class);

        // Route::get('/tickets/{ticket}/edit', EditTicket::class)->name('tickets.edit');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
