<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tournaments;
use App\Models\Teams;
use App\Models\TeamStat; 

class TeamStatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tournamentId = $request->input('tournament_id');
        $category = $request->query('category');
    
        $teams = Teams::with(['teamStats']) 
        ->when($tournamentId, function ($query) use ($tournamentId) {
            return $query->where('tournament_id', $tournamentId);
        })
        ->when($category, function ($query) use ($category) {
            return $query->where('category', $category);
        })
        ->get();
    
        $teamstats = TeamStat::all(); // Fetch all team statistics
    
        $tournaments = Tournaments::all(); // Fetch all tournaments
    
        return view('leaderboards.list', compact('teams', 'tournaments', 'teamstats'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
