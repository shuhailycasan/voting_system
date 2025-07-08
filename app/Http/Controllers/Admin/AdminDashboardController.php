<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(){
        //Example: get total votes per candidate
        $candidates = Candidate::withCount('votes')->get();

        // Example: count voters who already voted
        $totalVoters = User::where('role', 'voter')->count();
        $votedCount = User::where('role', 'voter')->where('voted', true)->count();

        return view('Admin.dashboard', compact('candidates', 'totalVoters', 'votedCount'));
    }



}

