<?php

use App\Http\Controllers\AskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AskController::class, 'index'])->name('dashboard');
    Route::post('/ask', [AskController::class, 'ask'])->name('ask');

    Route::get('/ask/async', [AskController::class, 'async'])->name('async.index');
    Route::post('/ask/async', [AskController::class, 'askAsync'])->name('async.ask');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
