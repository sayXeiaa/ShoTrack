<?php

namespace App\Http\Controllers;
use App\Models\Player;
use App\Models\Team;
use App\Models\Schedule;
use App\Models\Players;
use App\Models\PlayerStat;

use Illuminate\Http\Request;

class PlayerStatsController extends Controller
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
    public function create($schedule_id)
    {
        $schedule = Schedule::with(['team1.players', 'team2.players'])->findOrFail($schedule_id);
        $teams = [$schedule->team1, $schedule->team2];
        $players = $schedule->team1->players->merge($schedule->team2->players);

        $team1Name = $schedule->team1->name; 
        $team2Name = $schedule->team2->name;

        $playersTeamA = Players::where('team_id', $schedule->team1->id)->get();
        $playersTeamB = Players::where('team_id', $schedule->team2->id)->get();

         // Filter for starting and bench players for Team A
        $startingPlayersTeamA = $playersTeamA->where('is_starting', true)->take(5); // Assume 'is_starting' is the flag for starters
        $benchPlayersTeamA = $playersTeamA->where('is_starting', false);

        // Filter for starting and bench players for Team B
        $startingPlayersTeamB = $playersTeamB->where('is_starting', true)->take(5);
        $benchPlayersTeamB = $playersTeamB->where('is_starting', false);

        // Fetch total points for both teams
        $teamAScore = PlayerStat::whereHas('player', function ($query) use ($schedule) {
            $query->where('team_id', $schedule->team1->id);
        })->sum('points');

        $teamBScore = PlayerStat::whereHas('player', function ($query) use ($schedule) {
            $query->where('team_id', $schedule->team2->id);
        })->sum('points');

        return view('playerstats.create', compact('schedule_id', 'teams', 'players', 'team1Name', 'team2Name', 'playersTeamA', 'playersTeamB', 'startingPlayersTeamA', 
        'startingPlayersTeamB', 'benchPlayersTeamA', 'benchPlayersTeamB', 'teamAScore', 'teamBScore'));
    }

// public function store(Request $request)
// {
//     // Validate the request data
//     $validated = $request->validate([
//         'player_number' => 'required|integer',
//         'team' => 'required|integer', // Assume 'team' is the team_id, not the name
//         'type_of_stat' => 'required|string|in:two_point,three_point,free_throw,offensive_rebound,defensive_rebound,steal,block,assist,turnover,foul',
//         'result' => 'required|string|in:made,missed',
//         'schedule_id' => 'required|integer'
//     ]);

//     // Find the player by number and team ID
//     $player = Players::where('number', $validated['player_number'])
//                     ->where('team_id', $validated['team'])
//                     ->first();

//     if (!$player) {
//         return response()->json(['error' => 'Player not found'], 404);
//     }

//     // Check if a stat record for this player and schedule already exists
//     $stat = PlayerStat::where('player_id', $player->id)
//                     ->where('schedule_id', $validated['schedule_id'])
//                     ->first();

//     if (!$stat) {
//         // Create new record if not found
//         $stat = new PlayerStat();
//         $stat->player_id = $player->id; 
//         $stat->schedule_id = $validated['schedule_id'];
//         $stat->team_id = $validated['team']; 
//         $stat->points = 0; // Initialize points
//         $stat->setAttribute('two_pt_fg_attempt', 0);
//         $stat->setAttribute('two_pt_fg_made', 0); 
//         $stat->setAttribute('three_pt_fg_attempt', 0);
//         $stat->setAttribute('three_pt_fg_made', 0); 
//         $stat->setAttribute('free_throw_attempt', 0);
//         $stat->setAttribute('free_throw_made', 0);
//         $stat->setAttribute('rebounds', 0);
//         $stat->setAttribute('offensive_rebounds', 0);
//         $stat->setAttribute('defensive_rebounds', 0);
//         $stat->setAttribute('blocks', 0);
//         $stat->setAttribute('steals', 0);
//         $stat->setAttribute('turnovers', 0);
//         $stat->setAttribute('personal_fouls', 0);
        
//     }

//     // Update the stat
// if ($validated['type_of_stat'] === 'two_point') {
//     // Handle 2-point shots
//     if ($validated['result'] === 'made') {
//         $stat->setAttribute('two_pt_fg_made', $stat->getAttribute('two_pt_fg_made') + 1); // Increment 2_pt_fg_made column
//         $stat->setAttribute('two_pt_fg_attempt', $stat->getAttribute('two_pt_fg_attempt') + 1); // Increment 2_pt_fg_attempt
//         $stat->points += 2; // Add 2 points for a made 2-point shot
//     } else if ($validated['result'] === 'missed') {
//         $stat->setAttribute('two_pt_fg_attempt', $stat->getAttribute('two_pt_fg_attempt') + 1); // Increment 2_pt_fg_attempt
//     }
// } elseif ($validated['type_of_stat'] === 'three_point') {
//     // Handle 3-point shots
//     if ($validated['result'] === 'made') {
//         $stat->setAttribute('three_pt_fg_made', $stat->getAttribute('three_pt_fg_made') + 1); // Increment 3_pt_fg_made column
//         $stat->setAttribute('three_pt_fg_attempt', $stat->getAttribute('three_pt_fg_attempt') + 1); // Increment 3_pt_fg_attempt
//         $stat->points += 3; // Add 3 points for a made 3-point shot
//     } else if ($validated['result'] === 'missed') {
//         $stat->setAttribute('three_pt_fg_attempt', $stat->getAttribute('three_pt_fg_attempt') + 1); // Increment 3_pt_fg_attempt
//     } 
// } elseif ($validated['type_of_stat'] === 'free_throw') {
//     // Handle free throws
//     $stat->setAttribute('free_throw_attempt', $stat->getAttribute('free_throw_attempt') + 1); // Increment free_throw_attempt

//     if ($validated['result'] === 'made') {
//         $stat->setAttribute('free_throw_made', $stat->getAttribute('free_throw_made') + 1); // Increment free_throw_made column
//         $stat->points += 1; 
//     }
// } elseif ($validated['type_of_stat'] === 'offensive_rebound') {
//     // Handle free throws
//     $stat->setAttribute('rebounds', $stat->getAttribute('rebounds') + 1);
//     $stat->setAttribute('offensive_rebounds', $stat->getAttribute('offensive_rebounds') + 1); 

// } elseif ($validated['type_of_stat'] === 'defensive_rebound') {
//     // Handle free throws
//     $stat->setAttribute('rebounds', $stat->getAttribute('rebounds') + 1);
//     $stat->setAttribute('defensive_rebounds', $stat->getAttribute('defensive_rebounds') + 1); 

// } elseif ($validated['type_of_stat'] === 'block') {
//     // Handle free throws
//     $stat->setAttribute('blocks', $stat->getAttribute('blocks') + 1);
// } elseif ($validated['type_of_stat'] === 'steal') {
//     // Handle free throws
//     $stat->setAttribute('steals', $stat->getAttribute('steals') + 1);
// } elseif ($validated['type_of_stat'] === 'turnover') {
//     // Handle free throws
//     $stat->setAttribute('turnovers', $stat->getAttribute('turnovers') + 1);
// } elseif ($validated['type_of_stat'] === 'foul') {
//     // Handle free throws
//     $stat->setAttribute('personal_fouls', $stat->getAttribute('personal_fouls') + 1);
// } 


//     // Save the updated stat
//     $stat->save();

//     // Calculate total scores for both teams
//     $schedule = Schedule::findOrFail($validated['schedule_id']);
//     // Calculate total scores for both teams

//     $teamAScore = PlayerStat::whereHas('player', function ($query) use ($schedule) {
//         $query->where('team_id', $schedule->team1->id);
//     })->sum('points');

//     $teamBScore = PlayerStat::whereHas('player', function ($query) use ($schedule) {
//         $query->where('team_id', $schedule->team2->id);
//     })->sum('points');

//     return response()->json(['message' => 'Shot recorded successfully', 'teamAScore' => $teamAScore,
//         'teamBScore' => $teamBScore]);
// }

public function store(Request $request)
{
    // Validate the request data
    $validated = $request->validate([
        'player_number' => 'required|integer',
        'team' => 'required|integer',
        'type_of_stat' => 'required|string|in:two_point,three_point,free_throw,offensive_rebound,defensive_rebound,steal,block,assist,turnover,foul',
        'result' => 'required|string|in:made,missed',
        'schedule_id' => 'required|integer'
    ]);

    // Find the player by number and team ID
    $player = Players::where('number', $validated['player_number'])
                    ->where('team_id', $validated['team'])
                    ->first();

    if (!$player) {
        return response()->json(['error' => 'Player not found'], 404);
    }

    // Create or update the stat record
    $stat = PlayerStat::where('player_id', $player->id)
                    ->where('schedule_id', $validated['schedule_id'])
                    ->first();

    // Format player name as "F. Lastname"
    $formattedName = $player->first_name[0] . '. ' . $player->last_name;

    if (!$stat) {
        $stat = new PlayerStat();
        $stat->player_id = $player->id;
        $stat->schedule_id = $validated['schedule_id'];
        $stat->team_id = $validated['team'];
        $stat->points = 0; // Initialize points
        // Initialize other attributes
        $stat->setAttribute('two_pt_fg_attempt', 0);
        $stat->setAttribute('two_pt_fg_made', 0);
        $stat->setAttribute('three_pt_fg_attempt', 0);
        $stat->setAttribute('three_pt_fg_made', 0);
        $stat->setAttribute('free_throw_attempt', 0);
        $stat->setAttribute('free_throw_made', 0);
        $stat->setAttribute('rebounds', 0);
        $stat->setAttribute('offensive_rebounds', 0);
        $stat->setAttribute('defensive_rebounds', 0);
        $stat->setAttribute('blocks', 0);
        $stat->setAttribute('steals', 0);
        $stat->setAttribute('turnovers', 0);
        $stat->setAttribute('personal_fouls', 0);
    }

    // Update the stat based on the type of stat
    $points = 0;
    $action = '';
    if ($validated['type_of_stat'] === 'two_point') {
        if ($validated['result'] === 'made') {
            $stat->setAttribute('two_pt_fg_made', $stat->getAttribute('two_pt_fg_made') + 1);
            $stat->setAttribute('two_pt_fg_attempt', $stat->getAttribute('two_pt_fg_attempt') + 1);
            $points = 2;
            $action = 'MADE a 2-point field goal';
        } else {
            $stat->setAttribute('two_pt_fg_attempt', $stat->getAttribute('two_pt_fg_attempt') + 1);
            $action = 'MISSED a 2-point field goal';
        }
    } elseif ($validated['type_of_stat'] === 'three_point') {
        if ($validated['result'] === 'made') {
            $stat->setAttribute('three_pt_fg_made', $stat->getAttribute('three_pt_fg_made') + 1);
            $stat->setAttribute('three_pt_fg_attempt', $stat->getAttribute('three_pt_fg_attempt') + 1);
            $points = 3;
            $action = 'MADE a 3-point field goal';
        } else {
            $stat->setAttribute('three_pt_fg_attempt', $stat->getAttribute('three_pt_fg_attempt') + 1);
            $action = 'MISSED a 3-point field goal';
        }
    } elseif ($validated['type_of_stat'] === 'free_throw') {
        $stat->setAttribute('free_throw_attempt', $stat->getAttribute('free_throw_attempt') + 1);
        if ($validated['result'] === 'made') {
            $stat->setAttribute('free_throw_made', $stat->getAttribute('free_throw_made') + 1);
            $points = 1;
            $action = 'MADE a free throw';
        }
        elseif ($validated['result'] === 'missed') {
            $action = 'MISSED a free throw';
        }
    } elseif ($validated['type_of_stat'] === 'offensive_rebound') {
        $stat->setAttribute('rebounds', $stat->getAttribute('rebounds') + 1);
        $stat->setAttribute('offensive_rebounds', $stat->getAttribute('offensive_rebounds') + 1);
        $action = 'Grabbed an offensive rebound';
    } elseif ($validated['type_of_stat'] === 'defensive_rebound') {
        $stat->setAttribute('rebounds', $stat->getAttribute('rebounds') + 1);
        $stat->setAttribute('defensive_rebounds', $stat->getAttribute('defensive_rebounds') + 1);
        $action = 'Grabbed a defensive rebound';
    } elseif ($validated['type_of_stat'] === 'block') {
        $stat->setAttribute('blocks', $stat->getAttribute('blocks') + 1);
        $action = 'Blocked a shot';
    } elseif ($validated['type_of_stat'] === 'steal') {
        $stat->setAttribute('steals', $stat->getAttribute('steals') + 1);
        $action = 'Stole the ball';
    } elseif ($validated['type_of_stat'] === 'turnover') {
        $stat->setAttribute('turnovers', $stat->getAttribute('turnovers') + 1);
        $action = 'Committed a turnover';
    } elseif ($validated['type_of_stat'] === 'foul') {
        $stat->setAttribute('personal_fouls', $stat->getAttribute('personal_fouls') + 1);
        $action = 'Committed a foul';
    }

    // Save the updated stat
    $stat->points += $points;
    $stat->save();

    // Calculate total scores for both teams
    $schedule = Schedule::findOrFail($validated['schedule_id']);
    // Calculate total scores for both teams

    $teamAScore = PlayerStat::whereHas('player', function ($query) use ($schedule) {
        $query->where('team_id', $schedule->team1->id);
    })->sum('points');

    $teamBScore = PlayerStat::whereHas('player', function ($query) use ($schedule) {
        $query->where('team_id', $schedule->team2->id);
    })->sum('points');

    return response()->json([
        'message' => 'Shot recorded successfully',
        'playerName' => $formattedName, 
        'action' => $action,
        'points' => $points,
        'teamAScore' => $teamAScore,
        'teamBScore' => $teamBScore
    ]);
}



    /**
     * Display the specified resource.
     */
    public function show() 
    {
    
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
