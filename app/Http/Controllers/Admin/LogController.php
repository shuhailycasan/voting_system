<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // Optional: Filter by user or event
        $query = Activity::with('causer');

        if($request->filled('search')){
            $query->where('description', 'like', '%' . $request->search . '%')
                ->orWhere('log_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = $query->latest()->paginate(10);

        return view('Admin.features.logs', compact('logs'));

    }
}
