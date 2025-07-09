<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function ManageCandidates(Request $request){

        $search = $request->input('search');

        $candidatesAll = Candidate::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('position', 'like', '%' . $search . '%');
        })->paginate(5);

        //Example: get total votes per candidate
        $candidates = Candidate::withCount('votes')->get();

        // Example: count voters who already voted
        $totalVoters = User::where('role', 'voter')->count();
        $votedCount = User::where('role', 'voter')->where('voted', true)->count();

        return view('Admin.features.candidate-manage', compact('candidates','candidatesAll', 'totalVoters', 'votedCount','search'));

    }

    public function showCandidatePage(){
       return view('Admin.features.candidate-manage');
    }



}

