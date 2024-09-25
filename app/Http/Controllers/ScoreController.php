<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Teams;
use App\Models\Schedule;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'team_id' => 'required|exists:teams,id',
            'quarter' => 'required|integer|min:1|max:4',
            'score' => 'required|integer|min:0',
        ]);
    
        // Check if the score for the same schedule, team, and quarter already exists
        $existingScore = Score::where('schedule_id', $validated['schedule_id'])
            ->where('team_id', $validated['team_id'])
            ->where('quarter', $validated['quarter'])
            ->first();
    
        if ($existingScore) {
            // update score
            $existingScore->update(['score' => $existingScore->score + $validated['score']]);
            $message = 'Score updated successfully';
        } else {
            Score::create($validated);
            $message = 'Score created successfully';
        }
    
        // Fetch team id based on schedule
        $teams = Teams::where('schedule_id', $validated['schedule_id'])->pluck('id')->toArray();
    
        // check if there ar e 2 teams
        if (count($teams) >= 2) {
            $teamAScore = Score::where('schedule_id', $validated['schedule_id'])
                ->where('team_id', $teams[0]) 
                ->sum('score');
    
            $teamBScore = Score::where('schedule_id', $validated['schedule_id'])
                ->where('team_id', $teams[1]) 
                ->sum('score');
        } else {
            $teamAScore = 0; 
            $teamBScore = 0; 
        }
    
        return response()->json([
            'message' => $message,
            'teamAScore' => $teamAScore,
            'teamBScore' => $teamBScore,
        ]);
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
