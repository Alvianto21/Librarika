<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * User profile
     */
    public function index() {
        return view('dashboard.profile.index', [
            'title' => 'User Profile',
            'user' => Auth::user()
        ]);
    }
}
