<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteLoginController extends Controller
{
    public function showLoginForm(){
        return view('login');
    }

    public function login(Request $request){
        $validateCode = $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = User::where('code', $validateCode)->where('role','voter')->first();

        if (!$user) {
            return back()->with('error', 'Invalid voting code.');
        }

        if ($user->voted) {
            return redirect()->route('already-voted');
        }


        Auth::login($user);

        return redirect()->route('vote.page');

    }


}
