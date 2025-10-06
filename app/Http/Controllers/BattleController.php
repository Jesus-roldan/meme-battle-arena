<?php

namespace App\Http\Controllers;

use App\Models\Battle;
use Illuminate\Http\Request;
use App\Models\Vote;

class BattleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Battle::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        if ($request->get('status') === 'open') {
            $query->where('deadline', '>=', now());
        } elseif ($request->get('status') === 'closed') {
            $query->where('deadline', '<', now());
        }

        $battles = $query->withCount('memes')->latest()->paginate(10);

        return view('battles.index', compact('battles'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('battles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date|after:now',
        ]);

        $request->user()->battles()->create($data);

        return redirect()->route('battles.index')->with('success','Batalla creada.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Battle $battle)
    {
        // Cargar memes con su autor y ordenar por votes_count desc
        $memes = $battle->memes()->with('user')->orderByDesc('votes_count')->get();

        // ¿Ha votado el usuario actual en esta batalla?
        $userVote = null;
        if (auth()->check()) {
            $userVote = \App\Models\Vote::where('user_id', auth()->id())
                ->where('battle_id', $battle->id)
                ->first();
        }

        return view('battles.show', compact('battle','memes','userVote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Battle $battle)
    {
        if (auth()->id() !== $battle->user_id) abort(403);
        return view('battles.edit', compact('battle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Battle $battle)
    {
        if (auth()->id() !== $battle->user_id) abort(403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date|after:now',
        ]);

        $battle->update($data);

        return redirect()->route('battles.show', $battle)->with('success','Batalla actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Battle $battle)
    {
        if (auth()->id() !== $battle->user_id) abort(403);

        $battle->delete();

        return redirect()->route('battles.index')->with('success','Batalla eliminada.');
    }
}
