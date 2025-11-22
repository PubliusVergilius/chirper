<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $chirps = Chirp::with('user')
            ->latest()
            ->take(50)
            ->get();

        return view("home", ['chirps' => $chirps]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'message' => [
                    'required',
                    'string',
                    'max:255',
                    /* Make each chirp unique
                    Rule::unique('chirps')->where(function ($query) use ($user) {
                        return $query->where('user_id', $user->id);
                    })
                    */
                ]
            ],
            [
                'message.required' => 'Please write something to chirp!',

                'message.max' => 'Chirps must be 255 characters or less.'
            ]
        );
        /*
        \App\Models\Chirp::create([
            'message' => $validated['message'],
            'user_id' => null
        ]);
        */

        auth()->user()->chirps()->create($validated);

        return redirect('/')->with('success', 'Chirp created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        /* Shorter version of the below
         * $this->authorize('update', $chirp);
         */

        if ($request->user()->cannot('update', $chirp)) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => [
                'max:255'
            ]
        ]);

        $chirp->update($validated);

        return redirect('/')->with('success', 'Chirp edited!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('update', $chirp);

        $chirp->delete();

        return redirect('/')->with('success', 'Chirp deleted!');
    }

    public function show_profile(Chirp $chirp): View
    {

        $chirps = auth()->user()->chirps()
            ->latest()
            ->take(50)
            ->get();

        return view("profile", ['chirps' => $chirps]);
    }
}
