<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VoteLoginController;
use App\Models\Candidate;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;


//VOTERS ROUTES
Route::controller(VoteLoginController::class)->group(function () {
    Route::get('/', 'showLoginForm')->name('login.form');
    Route::post('/login-code', 'login')->name('vote.code.login');
});

Route::controller(VoteController::class)->middleware('auth')->group(function () {
    Route::get('/vote', 'showVotePage')->name('vote.page');
    Route::post('/vote-submit', 'submitVote')->name('vote.submit');

});

//voters taking picture after voting
Route::get('/vote/photo', function () {
    if (!auth()->check() || auth()->user()->voted) {
        return redirect()->route('login');
    }

    return view('web-cam');
})->name('vote.photo');

Route::post('/vote/photo', [VoteController::class, 'storePhoto'])->name('vote.photo.upload');

//Thank you page
Route::get('/thank-you', function () {
    return view('thankyou');
})->name('vote.thankyou');

//Already Voted page
Route::get('/already-voted', function () {
    return view('already-voted');
})->name('already-voted');


//ADMIN ROUTES
Route::controller(AdminLoginController::class)->group(function () {
    Route::get('/admin/login', 'showLoginForm')->name('admin.login');
    Route::post('/admin/login', 'login')->name('admin.login.submit');
});

Route::get('/admin/dashboard', [AdminDashboardController::class, 'showDashboard'])
    ->middleware('auth')->name('admin.dashboard');


// Admin Logout
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


//Profile Editing
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Admin Panel Controller
Route::controller(AdminDashboardController::class)->group(function () {
    Route::get('/admin/users-manage', 'ManageUsers')->name('admin.candidate.users');

    //CRUD FOR CANDIDATES
    Route::get('/admin/candidate-manage', 'ManageCandidates')->name('admin.candidate.table');
    Route::post('/admin/add-candidate', 'addCandidates')->name('admin.candidate.add');
    Route::put('/admin/candidates/{id}', 'updateCandidate')->name('admin.candidate.update');
    Route::delete('/admin/delete-candidate/{id}', 'deleteCandidates')->name('admin.candidate.delete');

    //CRUD FOR POSITIONS
    Route::post('/admin/add-position', 'addPositions')->name('admin.position.add');
    Route::get('/admin/users-position', 'ManagePosition')->name('admin.position');
    Route::put('/admin/positions/{id}', 'updatePosition')->name('admin.position.update');
    Route::delete('/admin/delete-position/{id}', 'deletePositions')->name('admin.position.delete');

    //EXPORTS AND IMPORTS
    Route::get('/admin/export-voters', 'exportUsers')->name('admin.export.voters');
    Route::post('/admin/import-voters', 'importVoters')->name('admin.import.voters');
    Route::get('/admin/export/candidates', 'exportCandidates')->name('admin.export.candidates');
    Route::get('/admin/export/positions', 'exportPositions')->name('admin.export.positions');
    Route::get('/admin/export/rankings', 'exportRankings')->name('admin.export.rankings');

    //Generates 6-code
    Route::post('/admin/generate-code', 'generateCode')->name('admin.users.generate-code');
    //Rankings
    Route::get('/admin/rankings', 'showRankings')->name('admin.rankings');

})->middleware('auth');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::get('/admin/logs', [LogController::class, 'index'])->name('admin.logs.index')->middleware('auth');

require __DIR__ . '/auth.php';
