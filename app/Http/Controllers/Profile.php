<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Profile extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $chirps = auth()->user()->chirps()
            ->latest()
            ->take(50)
            ->get();

        return view("profile", ['chirps' => $chirps]);
    }
}
