<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            'title' => 'Dashboard'
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

    /**
     * Registrasi pengguna baru
     */
    public function register() {
        return view('login.register', ['title' => 'Register Page']);
    }

    /**
     * Menagani registrasi pengguna baru
     */
    public function store(Request $request) {
        $credentials = $request->validate([
            'nama' => 'required|regex:/^[\pL\s]+$/u|max:255',
            'email' => 'required|email:dns|unique:users,email',
            'username' => 'required|alpha_num|max:150|unique:users,username',
            'foto_profil' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        if ($request->hasFile('foto_profil')) {
            $credentials['foto_profil'] = $request->file('foto_profil')->store('foto-profil', 'public');
        }

        User::create($credentials);

        return redirect('/login')->with('RegisterSuccess', "registrasi berhasil! Silahkan login.");
    }
}
