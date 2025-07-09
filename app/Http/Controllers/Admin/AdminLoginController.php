<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm(){
        return view('Admin.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('name', $credentials['name'])->where('role','admin')->first();

        if (!$user || !\Hash::check($credentials['password'], $user->password)) {
            return back()->with('error', 'Invalid login credentials.');
        }

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request){

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');


    }
}

