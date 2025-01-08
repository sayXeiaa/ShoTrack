<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tournaments;
use App\Models\Teams;
use App\Models\TeamStat; 
use App\Models\Schedule;

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
    
        // Get unique schedules for the selected tournament
        $schedules = Schedule::where('tournament_id', $tournamentId)
            ->when($category, function ($query) use ($category) {
                return $query->where('category', $category);
            })
            ->get();
    
        // Calculate averages for each team
        $averages = [];
    
        foreach ($teams as $team) {
            // Filter team statistics based on unique schedules
            $teamStats = $team->teamStats->whereIn('schedule_id', $schedules->pluck('id'))->unique('schedule_id');
    
            $totalGames = $teamStats->count();
            $totalMinutes = 0;
            $totalPoints = 0;
            $totalFGM = 0;
            $totalFGA = 0;
    
            // Accumulate values
            foreach ($teamStats as $stats) {
                $totalMinutes += $stats->minutes;
                $totalPoints += $stats->points;
                $totalFGM += $stats->two_pt_fg_made + $stats->three_pt_fg_made;
                $totalFGA += $stats->two_pt_fg_attempt + $stats->three_pt_fg_attempt;
            }
    
            // Calculate averages
            $avgFGP = $totalFGA > 0 ? ($totalFGM / $totalFGA) * 100 : 0;
            $avgMinutes = $totalGames > 0 ? $totalMinutes / $totalGames : 0;
            $avgPoints = $totalGames > 0 ? $totalPoints / $totalGames : 0;
    
            $averages[$team->id] = [
                'avg_fgp' => $avgFGP,
                'avg_minutes' => $avgMinutes,
                'avg_points' => $avgPoints,
            ];
        }
    
        $tournaments = Tournaments::all();
        
        return view('leaderboards.list', compact('teams', 'tournaments', 'averages'));
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
