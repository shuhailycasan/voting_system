<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


//VOTERS ROUTES
Route::controller(VoteLoginController::class)->group(function () {
    Route::get('/', 'showLoginForm')->name('login.form');
    Route::post('/login-code', 'login')->name('vote.code.login');
});

Route::controller(VoteController::class)->middleware('auth')->group(function () {
    Route::get('/vote', 'showVotePage')->name('vote.page');
    Route::post('/vote-submit', 'submitVote')->name('vote.submit');

    Route::get('/thankyou', function () {
        return view('thankyou');
    })->name('vote.thankyou');

    Route::get('/already-voted', function () {
        return view('already-voted');
    })->name('already-voted');
});


//ADMIN ROUTES
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
