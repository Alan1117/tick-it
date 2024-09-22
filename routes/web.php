<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::any('tickets/search', [\App\Http\Controllers\TicketController::class, 'search'])->name('tickets.search');
    Route::any('tickets/reopen/{ticket}', [\App\Http\Controllers\TicketController::class, 'reopen'])->name('tickets.reopen');
    Route::resource('tickets',\App\Http\Controllers\TicketController::class);
});

require __DIR__.'/auth.php';
