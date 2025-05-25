<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function handleLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended();
        }

        return redirect()->back()->withInput()->with('error', 'Email or password is incorrect.');
    }

    public function handleLogout()
    {
        Auth::logout();

        return $this->responseSuccess([]);
    }
}
