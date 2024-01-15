<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{    
    /**
     * Method index
     *
     * @return void
     */
    public function index()
    {
        $user = auth()->user();

        return view('pages.profile.index', compact('user'));
    }
}
