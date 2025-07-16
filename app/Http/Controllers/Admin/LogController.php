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
        $query = Activity::query();

        if ($request->has('user')) {
            $query->where('causer_id', $request->user);
        }

        if ($request->has('event')) {
            $query->where('description', 'like', '%' . $request->event . '%');
        }

        $logs = $query->latest()->paginate(5);

        return view('Admin.features.logs', compact('logs'));
    }
}
