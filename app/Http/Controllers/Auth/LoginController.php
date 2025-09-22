<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * login page
     */
    public function login() {
        return view("login.index", ['title' => 'Login Page']);
    }

    /**
     * Menagani percobaan otorisasi
     */
    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with('LoginError', "email atau password salah!")->withInput();
    }

    /**
     * Dashboard page
     */
    public function dashboard() {
        return view("dashboard.index" , [
            'title' => 'Dashboard',
            'user' => Auth::user()->nama
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request) {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
