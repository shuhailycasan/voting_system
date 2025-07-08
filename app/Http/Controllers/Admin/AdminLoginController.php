<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function logout(){
        Auth:$this->logout();
        return redirect()->route('admin.login');
    }
}
