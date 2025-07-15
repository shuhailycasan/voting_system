<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


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
        $add_candidates = $request->validate([
            'name' => 'required',
            'position' => 'required',
        ]);

        Candidate::create($add_candidates);

        return redirect()
            ->route('admin.candidate.table')
            ->with('success', 'Candidate added successfully!');
    }

    public function deleteCandidates($id){
        $delCandidate = Candidate::findOrFail($id);

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

        $candidates = Candidate::withCount('votes')->get();

        $notVotedUsers = $totalVoters - $votedCount;

        $groupedCandidates = $candidates->groupBy('position');


        return view('Admin.features.dash-charts', compact('labels', 'data','totalVoters', 'votedCount', 'candidates','groupedCandidates','notVotedUsers'));

    }


        public function ManageUsers(Request $request)
    {

        $search = $request->input('search_users');

        $usersAll = User::query()
            ->when($search, function ($query, $search) {
                $query->where('code', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%');
            })->paginate(5);


        return view('Admin.features.users-manage', compact('usersAll','search'));

    }

    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

}

