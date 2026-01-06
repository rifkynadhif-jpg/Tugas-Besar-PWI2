<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('authenticated')) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($request->password === 'root') {
            session(['authenticated' => true, 'username' => $request->username]);
            return redirect()->route('home')->with('success', 'Selamat datang, ' . $request->username . '!');
        }

        return back()->withErrors(['password' => 'Password salah. Gunakan password: root']);
    }

    public function logout()
    {
        session()->forget(['authenticated', 'username']);
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
