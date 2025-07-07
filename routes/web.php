<?php

use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VoteLoginController;


Route::controller(VoteLoginController::class)->group(function () {
    Route::get('/', 'showLoginForm')->name('login.form');
    Route::post('/login-code', 'login')->name('vote.code.login');
});

Route::controller(VoteController::class)->group(function () {
    Route::get('/vote', 'votePage')->middleware('auth')->name('vote.page');

    // Voting page (after code login)
    Route::get('/vote', 'showVotePage')->middleware('auth')->name('vote.page');

    // Submit vote
    Route::post('/vote', 'submitVote')->middleware('auth')->name('vote.submit');

    // Thank you page
    Route::get('/thankyou', function () {
        return view('thankyou');
    })->name('vote.thankyou');

});

