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

        return redirect()->route('vote.photo');

    }

    public function storePhoto(Request $request)
    {
        try {
            $request->validate([
                'photo' => 'required|image|max:2048',
            ]);

            $user = Auth::user();

            if (!$user) {
                Log::error('No authenticated user found during photo upload.');
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $user->addMediaFromRequest('photo')->toMediaCollection('vote_photo');

            $user->voted = true;
            $user->voted_at = now();
            $user->save();

            Auth::logout();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Photo upload failed: ' . $e->getMessage());
            return response()->json(['error' => 'Upload failed'], 500);
        }
    }
}
