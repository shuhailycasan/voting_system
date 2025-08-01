<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CandidatesExport;
use App\Exports\PositionsExport;
use App\Exports\RankingsExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\VoterCodeImport;
use App\Models\Candidate;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class AdminDashboardController extends Controller
{

//    CRUD FOR CANDIDATES
    public function ManageCandidates(Request $request)
    {
        $searchCandidate = $request->input('search_candidate');
        $searchPosition = $request->input('search_position');

        $candidatesAll = Candidate::with(['media', 'position'])
            ->when($searchCandidate, function ($query, $search) {
                $query->where('name', 'like', "%$search%");
            })
            ->paginate(5, ['*'], 'candidates_page');


        $positionsAll = Position::when($searchPosition, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('max_votes', 'like', "%$search%")
                    ->orWhere('type', 'like', "%$search%");
            });
        })
            ->paginate(5, ['*'], 'positions_page');


        return view('Admin.features.candidate-manage', compact('candidatesAll','searchCandidate','searchPosition', 'positionsAll'));
    }

    public function addCandidates(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $candidate = new Candidate();
        $candidate->name = $request->name;
        $candidate->position_id = $request->position_id;
        $candidate->save();

        if ($request->hasFile('photo')) {
            try {
                $candidate->addMediaFromRequest('photo')->toMediaCollection('candidate_photo');
            } catch (\Exception $e) {
                return redirect()
                    ->route('admin.candidate.table')
                    ->with('error', 'Candidate saved, but image upload failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.candidate.table')->with('success', 'Candidate added successfully!');
    }

    public function updateCandidate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position_id' => 'required|integer|exists:positions,id',
            'photo' => 'nullable|image|max:2048',
        ]);

        $candidate = Candidate::findOrFail($id);

        $candidate->update([
            'name' => $validated['name'],
            'position_id' => $validated['position_id'],
        ]);

        if ($request->hasFile('photo')) {
            $candidate->clearMediaCollection('candidate_photo');
            $candidate->addMediaFromRequest('photo')->toMediaCollection('candidate_photo');
        }

        return redirect()->back()->with('success', 'Candidate updated successfully.');
    }

    public function deleteCandidates($id)
    {
        $delCandidate = Candidate::findOrFail($id);

        // Log the delete activity BEFORE deleting
        activity()
            ->causedBy(auth()->user()) 
            ->performedOn($delCandidate)
            ->withProperties(['candidate_name' => $delCandidate->name, 'position' => $delCandidate->position])
            ->log("Deleted candidate {$delCandidate->name}");

        $delCandidate->delete();

        return redirect()->route('admin.candidate.table')->with('deleted', 'Candidate deleted successfully!');
    }


    //CRUD FOR POSITIONS
    public function addPositions(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:single,multiple',
            'max_votes' => 'required|integer|min:1',
            'order' => 'required|integer',
        ]);

        $position = new Position();
        $position->name = $request->name;
        $position->type = $request->type;
        $position->max_votes = $request->max_votes;
        $position->save();

        return redirect()->route('admin.candidate.table')->with('success', 'Position added successfully!');
    }

    public function updatePosition(Request $request, $id)
    {
        Log::info('updatePosition hit', $request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:single,multiple',
            'max_votes' => 'required|integer|min:1',
            'order' => 'required|integer',
        ]);

        $position = Position::findOrFail($id);

        $position->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'max_votes' => $validated['max_votes'],
            'order' => $validated['order'],
        ]);

        return redirect()->back()->with('success', 'Position updated successfully.');
    }

    public function deletePositions($id)
    {
        $delPosition = Position::findOrFail($id);

        // Log the delete activity BEFORE deleting
        activity()
            ->causedBy(auth()->user()) // who did it
            ->performedOn($delPosition) // what was affected
            ->withProperties(['Position_name' => $delPosition->name, 'position' => $delPosition->position_id])
            ->log("Position candidate {$delPosition->name}");

        $delPosition->delete();

        return redirect()->route('admin.candidate.table')->with('deleted', 'Position deleted successfully!');
    }

    //CRUD FOR USERS
    public function ManageUsers(Request $request)
    {
        $search = request('search_users');
        $page = request('page', 1);


        $usersAll = User::query()
            ->with('media')
            ->when($search, function ($query, $search) {
                $query->where('code', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%');
            })
            ->paginate(5, ['*'], 'voterspage');
        return view('Admin.features.users-manage', compact('usersAll', 'search'));
    }

    public function generateCode()
    {
        do {
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (User::where('code', $code)->exists());

        $user = User::create([
            'code' => $code,
            'role' => 'voter',
        ]);

        return back()->with('success', "New voter created with code {$code} and ID {$user->id}");

    }


    //DASHBOARD
    public function showDashboard()
    {
        $candidates = Candidate::withCount('votes')->with('position')->get();

        $labels = $candidates->pluck('name');
        $data = $candidates->pluck('candidate_id');

        // Example: count voters who already voted
        $totalVoters = User::where('role', 'voter')->count();
        $votedCount = User::where('role', 'voter')->where('voted', true)->count();

        //TIME
        $votesByHour = User::selectRaw("DATE_FORMAT(voted_at, '%H:00') as hour, COUNT(*) as count")
            ->whereNotNull('voted_at')
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour');

//        $votesByHour = User::whereNotNull('voted_at')->get()->groupBy(fn($user) => Carbon::parse($user->voted_at)->format('H:00'))->map(fn($group) => $group->count())->sortKeys();

        //Total Candidates
        $totalCandidates = Candidate::count();

        //Still not voted
        $notVotedUsers = $totalVoters - $votedCount;

        $groupedCandidates = $candidates->groupBy(fn($c) => $c->position->name ?? 'No position');

        return view('Admin.features.dash-charts', compact('labels', 'data', 'totalVoters', 'votedCount', 'candidates', 'groupedCandidates', 'notVotedUsers', 'totalCandidates', 'votesByHour'));
    }

    public function showRankings()
    {
        // Fetch all positions ordered by `order`
        $positions = Position::orderBy('order')->get();

        // Preload candidates for each position, sorted by votes
        $candidates = Candidate::with(['media', 'position'])
            ->withCount('votes')
            ->whereNotNull('position_id')
            ->get();

        $groupedRankings = $candidates
            ->groupBy(fn($candidates) => $candidates->position->name ?? 'No position')
            ->map(fn($group) => $group->sortByDesc('votes_count')->values());

        return view('Admin.features.rankings', compact('groupedRankings'));
    }


    //PUBLIC FUNCTION FOR EXPORTING AND IMPORTING
    public function exportUsers()
    {
        return Excel::download(new UsersExport(), 'users.xlsx');
    }

    public function importVoters(Request $request)
    {
        $request->validate([
            'voters_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('voters_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        // Skip header if present
        if (strtolower(trim($data[0][0])) === 'code') {
            array_shift($data);
        }

        foreach ($data as $row) {
            User::create([
                'code' => $row[0],
                'role' => 'voter',
                'voted' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Voters codes imported successfully!');
    }

    public function exportCandidates()
    {
        return Excel::download(new CandidatesExport(), 'candidates.xlsx');
    }

    public function exportPositions()
    {
        return Excel::download(new PositionsExport(), 'positions.xlsx');
    }

    public function exportRankings()
    {
        return Excel::download(new RankingsExport(), 'rankings.xlsx');
    }

}
