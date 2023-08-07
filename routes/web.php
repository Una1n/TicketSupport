<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Categories\CreateCategory;
use App\Livewire\Categories\EditCategory;
use App\Livewire\Categories\ListCategory;
use App\Livewire\DashboardHome;
use App\Livewire\Labels\CreateLabel;
use App\Livewire\Labels\EditLabel;
use App\Livewire\Labels\ListLabel;
use App\Livewire\Users\CreateUser;
use App\Livewire\Users\EditUser;
use App\Livewire\Users\ListUser;
use App\Models\Category;
use App\Models\Label;
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

    Route::middleware('can:manage,' . Category::class)->group(function () {
        Route::get('/categories', ListCategory::class)->name('categories.index');
        Route::get('/categories/create', CreateCategory::class)->name('categories.create');
        Route::get('/categories/{category}/edit', EditCategory::class)->name('categories.edit');
    });

    Route::middleware('can:manage,' . Label::class)->group(function () {
        Route::get('/labels', ListLabel::class)->name('labels.index');
        Route::get('/labels/create', CreateLabel::class)->name('labels.create');
        Route::get('/labels/{label}/edit', EditLabel::class)->name('labels.edit');
    });

    Route::middleware('can:manage,' . User::class)->group(function () {
        Route::get('/users', ListUser::class)->name('users.index');
        Route::get('/users/create', CreateUser::class)->name('users.create');
        Route::get('/users/{user}/edit', EditUser::class)->name('users.edit');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
