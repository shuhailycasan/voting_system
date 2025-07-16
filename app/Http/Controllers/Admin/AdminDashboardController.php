<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\VoterCodeImport;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;


class AdminDashboardController extends Controller
{
    public function ManageCandidates(Request $request)
    {

        $search = $request->input('search');

        $candidatesAll = Candidate::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('position', 'like', '%' . $search . '%');
            })->paginate(5);


        return view('Admin.features.candidate-manage', compact('candidatesAll', 'search'));
    }

    public function addCandidates(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $candidate = new Candidate();
        $candidate->name = $request->name;
        $candidate->position = $request->position;
        $candidate->save();

        if ($request->hasFile('photo')) {
            $candidate->addMediaFromRequest('photo')->toMediaCollection('candidate_photo');
        }

        return redirect()
            ->route('admin.candidate.table')
            ->with('success', 'Candidate added successfully!');
    }


    public function updateCandidate(Request $request, $id)
    {
        $candidate = Candidate::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $candidate->update([
            'name' => $validated['name'],
            'position' => $validated['position'],
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
            ->causedBy(auth()->user()) // who did it
            ->performedOn($delCandidate) // what was affected
            ->withProperties(['candidate_name' => $delCandidate->name, 'position' => $delCandidate->position])
            ->log("Deleted candidate {$delCandidate->name}");

        $delCandidate->delete();

        return redirect()->route('admin.candidate.table')
            ->with('deleted', 'Candidate deleted successfully!');
    }

    public function showDashboard()
    {
        $candidates = Candidate::withCount('votes')->get();

        $labels = $candidates->pluck('name');
        $data = $candidates->pluck('candidate_id');

        // Example: count voters who already voted
        $totalVoters = User::where('role', 'voter')->count();
        $votedCount = User::where('role', 'voter')->where('voted', true)->count();

        //Total Candidates
        $totalCandidates = Candidate::count();

        //Still not voted
        $notVotedUsers = $totalVoters - $votedCount;

        $groupedCandidates = $candidates->groupBy('position');

        return view('Admin.features.dash-charts', compact('labels', 'data', 'totalVoters', 'votedCount', 'candidates', 'groupedCandidates', 'notVotedUsers', 'totalCandidates'));
    }

    public function ManageUsers(Request $request)
    {

        $search = $request->input('search_users');

        $usersAll = User::query()
            ->when($search, function ($query, $search) {
                $query->where('code', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%');
            })->paginate(5);


        return view('Admin.features.users-manage', compact('usersAll', 'search'));

    }

    public function showRankings()
    {
        $candidates = Candidate::withCount('votes')
            ->orderBy('position')
            ->orderByDesc('votes_count')
            ->get();

        $grouped = $candidates->groupBy('position');

        // Define your preferred order
        $positionOrder = ['President', 'Vice-President', 'Secretary', 'business_manager'];

        // Reorder grouped collection
        $groupedRankings = collect($positionOrder)->mapWithKeys(function ($position) use ($grouped) {
            return [$position => $grouped->get($position, collect())];
        });

        return view('Admin.features.rankings', compact('groupedRankings'));
    }

    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function importVoters(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx'
        ]);

        Excel::import(new VoterCodeImport, $request->file('voters_file'));

        return redirect()->back()->with('success', 'Voters codes imported successfully!');


    }

}

