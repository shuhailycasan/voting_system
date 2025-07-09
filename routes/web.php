<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VoteLoginController;
use App\Models\Candidate;
use Illuminate\Support\Facades\Route;


//VOTERS ROUTES
Route::controller(VoteLoginController::class)->group(function () {
    Route::get('/', 'showLoginForm')->name('login.form');
    Route::post('/login-code', 'login')->name('vote.code.login');
});

Route::controller(VoteController::class)->middleware('auth')->group(function () {
    Route::get('/vote', 'showVotePage')->name('vote.page');
    Route::post('/vote-submit', 'submitVote')->name('vote.submit');
});

Route::get('/thank-you', function () {
    return view('thankyou');
})->name('vote.thankyou');


Route::get('/already-voted', function () {
    return view('already-voted');
})->name('already-voted');



//ADMIN ROUTES
Route::controller(AdminLoginController::class)->group(function () {
    Route::get('/admin/login', 'showLoginForm')->name('admin.login');
    Route::post('/admin/login', 'login')->name('admin.login.submit');
});

Route::get('/admin/dashboard', function () {
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Unauthorized');
    }

    $candidates = Candidate::withCount('votes')->get();

    $groupedCandidates = $candidates->groupBy('position');


    return view('Admin.features.dash-charts', compact('groupedCandidates'));
})->middleware('auth')->name('admin.dashboard');



// Admin Logout
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


//Profile Editing
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(AdminDashboardController::class)->group(function () {
    Route::get('/admin/candidate-manage', 'ManageCandidates')->name('admin.candidate.table');

    Route::post('/admin/add-candidate', 'addCandidates')->name('admin.candidate.add');
    Route::delete('/admin/delete-candidate/{id}', 'deleteCandidates')->name('admin.candidate.delete');

})->middleware('auth');

require __DIR__.'/auth.php';
