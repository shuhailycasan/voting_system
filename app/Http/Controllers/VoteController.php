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
        $votes = $request->input('votes'); // this is an associative array like ['President' => 2]

        $user = Auth::user();

        if ($user->voted) {
            return redirect()->route('already-voted');
        }

        foreach ($votes as $position => $candidateIdOrArray) {

            //  Check if this position allows multiple votes
            if (is_array($candidateIdOrArray)) {
                foreach ($candidateIdOrArray as $candidateId) {
                    $candidate = Candidate::findOrFail($candidateId);

                    Vote::create([
                        'user_id' => $user->id,
                        'candidate_id' => $candidate->id,
                        'position' => $position,
                    ]);
                }
            } else {
                $candidate = Candidate::findOrFail($candidateIdOrArray);

                Vote::create([
                    'user_id' => $user->id,
                    'candidate_id' => $candidate->id,
                    'position' => $position,
                ]);
            }
        }

        $user->voted = true;
        $user->voted_at = now();
        $user->save();

        Auth::logout();

        return redirect()->route('vote.thankyou');

    }
}
