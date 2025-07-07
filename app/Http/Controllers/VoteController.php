<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function showVotePage()
    {
        $candidates = Candidate::all();
        return view('vote.vote', compact('candidates'));
    }

    public function submitVote(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $user = Auth::user();

        // prevent double voting just in case
        if ($user->voted) {
            return redirect()->route('already-voted');
        }

        // store the vote
        Vote::create([
            'user_id' => $user->id,
            'candidate_id' => $request->candidate_id,
        ]);

        // mark user as voted
        $user->voted = true;
        $user->save();

        Auth::logout();

        return redirect()->route('vote.thankyou');
    }
}
