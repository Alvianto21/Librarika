<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomesController extends Controller
{
    // Home page
    public function index() {
        return view("homes.index", ['title' => 'Home Page']);
    }

    // About page
    public function about() {
        return view('homes.about', ['title' => 'About Page']);
    }
}
