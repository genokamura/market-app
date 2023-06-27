<?php

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Item\ExhibitController;
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


Route::middleware(['auth', 'verified', 'verified.full'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/exhibit', [ExhibitController::class, 'create'])->name('item.exhibit.create');
    Route::post('/exhibit', [ExhibitController::class, 'store'])->name('item.exhibit.store');
    Route::get('/exhibit/complete/{id}', [ExhibitController::class, 'complete'])->name('item.exhibit.complete');

});

Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile-email', [ProfileController::class, 'updateEmail'])->name('profile.update.email');

    Route::middleware(['verified'])->group(function () {
        Route::get('/register/full', function () {
            return view('auth.register-full');
        })->name('register.full');
    });

    Route::middleware('verified.full')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/register-complete', function () {
            return view('auth.register-complete');
        })->name('register.complete');
    });
});

require __DIR__.'/auth.php';
