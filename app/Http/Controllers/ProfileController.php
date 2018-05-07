<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profiles.index');
    }

    public function account()
    {
        return view('profiles.account');
    }

    public function password()
    {
        return view('profiles.password');
    }

    public function settings()
    {
        return view('profiles.settings');
    }

    public function activities()
    {
        return view('profiles.activities');
    }
}
