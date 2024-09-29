<?php

namespace App\Http\Controllers;
use App\Models\Player;
use App\Models\Teams;
use App\Models\Schedule;
use App\Models\Players;
use App\Models\PlayerStat;
use App\Models\Tournaments;
use App\Models\PlayByPlay;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Score;

class PlayerStatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    // Retrieve the schedule_id from query parameters
    $scheduleId = $request->query('schedule_id');

    // Find the schedule with its teams and ensure it exists
    $schedule = Schedule::with(['team1', 'team2'])->find($scheduleId);
    if (!$schedule) {
        return redirect()->route('playerstats.index')->with('error', 'Schedule not found.');
    }

    // Retrieve player statistics for both teams in the specified schedule
    $playerStatsTeam1 = PlayerStat::with('player') // Eager load player data
        ->where('schedule_id', $scheduleId)
        ->where('team_id', $schedule->team1_id)
        ->get();

    $playerStatsTeam2 = PlayerStat::with('player') // Eager load player data
        ->where('schedule_id', $scheduleId)
        ->where('team_id', $schedule->team2_id)
        ->get();

    // Retrieve remaining players not in the player statistics
    $remainingPlayersTeam1 = Players::where('team_id', $schedule->team1_id)
        ->whereNotIn('id', $playerStatsTeam1->pluck('player_id')) // Exclude players with stats
        ->get();

    $remainingPlayersTeam2 = Players::where('team_id', $schedule->team2_id)
        ->whereNotIn('id', $playerStatsTeam2->pluck('player_id')) // Exclude players with stats
        ->get();

     // Fetch total points for both teams
    $teamAScore = PlayerStat::whereHas('player', function ($query) use ($schedule) {
        $query->where('team_id', $schedule->team1->id);
    })->sum('points');

    $teamBScore = PlayerStat::whereHas('player', function ($query) use ($schedule) {
        $query->where('team_id', $schedule->team2->id);
    })->sum('points');

    // Pass data to the view
    return view('playerstats.list', compact('schedule', 'playerStatsTeam1', 'playerStatsTeam2', 'remainingPlayersTeam1', 'remainingPlayersTeam2', 'teamAScore', 'teamBScore'));
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

        $remaining_game_time = $schedule->remaining_game_time; 
        $currentQuarter = $schedule->current_quarter; 

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
        'startingPlayersTeamB', 'benchPlayersTeamA', 'benchPlayersTeamB', 'teamAScore', 'teamBScore', 'remaining_game_time', 'currentQuarter'));
    }

    public function store(Request $request)
    {
        Log::info('Received data:', $request->all());
        $validated = $request->validate([
            'player_number' => 'required|integer',
            'team' => 'required|integer',
            'type_of_stat' => 'required|string|in:two_point,three_point,free_throw,offensive_rebound,defensive_rebound,steal,block,assist,turnover,foul',
            'result' => 'required|string|in:made,missed',
            'schedule_id' => 'required|integer',
            'game_time' => 'required|string',
            'quarter' => 'required|string',
        ]);
        Log::info('Shot result:', ['result' => $validated['result']]);

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

        // If no stat record exists, create a new one
        if (!$stat) {
            $stat = new PlayerStat();
            $stat->player_id = $player->id;
            $stat->schedule_id = $validated['schedule_id'];
            $stat->team_id = $validated['team'];
            $stat->points = 0;
            $stat->setAttribute('two_pt_fg_attempt', 0);
            $stat->setAttribute('two_pt_fg_made', 0);
            $stat->setAttribute('two_pt_percentage', 0);
            $stat->setAttribute('three_pt_fg_attempt', 0);
            $stat->setAttribute('three_pt_fg_made', 0);
            $stat->setAttribute('three_pt_percentage', 0);
            $stat->setAttribute('free_throw_attempt', 0);
            $stat->setAttribute('free_throw_made', 0);
            $stat->setAttribute('free_throw_percentage', 0);
            $stat->setAttribute('free_throw_attempt_rate', 0);
            $stat->setAttribute('rebounds', 0);
            $stat->setAttribute('offensive_rebounds', 0);
            $stat->setAttribute('defensive_rebounds', 0);
            $stat->setAttribute('assists', 0);
            $stat->setAttribute('blocks', 0);
            $stat->setAttribute('steals', 0);
            $stat->setAttribute('turnovers', 0);
            $stat->setAttribute('personal_fouls', 0);
            $stat->setAttribute('effective_field_goal_percentage', 0);
            $stat->setAttribute('minutes', 0);
        }
        
        // Use helper methods to determine points and action
        $points = $this->getPoints($validated['type_of_stat'], $validated['result']);

        // Update the stat based on the type of stat
        switch ($validated['type_of_stat']) {
            case 'two_point':
                // Increment the number of attempts
                $stat->two_pt_fg_attempt++;

                if ($validated['result'] === 'made') {
                    $stat->two_pt_fg_made++;
                    $stat->points += $points; 
                }

                // Calculate the percentage
                $attempts = $stat->two_pt_fg_attempt;
                $makes = $stat->two_pt_fg_made;

                $percentage = ($attempts > 0) ? ($makes / $attempts) * 100 : 0;

                // Set the percentage
                $stat->two_pt_percentage = $percentage;
                $stat->save(); 

                break;

            case 'three_point':
                Log::info('Before Increment: ', ['three_pt_fg_attempt' => $stat->three_pt_fg_attempt]);
                $stat->three_pt_fg_attempt++;
                Log::info('After Increment: ', ['three_pt_fg_attempt' => $stat->three_pt_fg_attempt]);
                if ($validated['result'] === 'made') {
                    $stat->three_pt_fg_made++;
                    $stat->points += $points;
                }
    
                $attempts = $stat->three_pt_fg_attempt;
                $makes = $stat->three_pt_fg_made;
    
                 $percentage = ($attempts > 0) ? ($makes / $attempts) * 100 : 0;
    
                $stat->three_pt_percentage = $percentage;
                $stat->save(); 
    
                break;
            
            case 'free_throw':
                $stat->free_throw_attempt++;
                if ($validated['result'] === 'made') {
                    $stat->free_throw_made++;
                    $stat->points += $points;
                }

                $attempts = $stat->free_throw_attempt;
                $makes = $stat->free_throw_made;

                $percentage = ($attempts > 0) ? ($makes / $attempts) * 100 : 0;

                $stat->free_throw_percentage = $percentage;

                // Calculate the free throw attempt rate
                $two_pt_attempts = $stat->two_pt_fg_attempt;
                $three_pt_attempts = $stat->three_pt_fg_attempt;
                $free_throw_attempt = $stat->free_throw_attempt;

                // Calculate the free throw attempt rate
                $total_fg_attempts = $two_pt_attempts + $three_pt_attempts;
                $fta_rate = ($total_fg_attempts > 0) ? ($free_throw_attempt / $total_fg_attempts) : 0;

                // Set the free throw attempt rate 
                $stat->free_throw_attempt_rate = $fta_rate * 100;
                $stat->save(); 

                break;
            case 'offensive_rebound':
                $stat->increment('rebounds');
                $stat->increment('offensive_rebounds');
                break;
            case 'defensive_rebound':
                $stat->increment('rebounds');
                $stat->increment('defensive_rebounds');
                break;
            case 'block':
                $stat->increment('blocks');
                break;
            case 'steal':
                $stat->increment('steals');
                break;
            case 'turnover':
                $stat->increment('turnovers');
                break;
            case 'foul':
                $stat->increment('personal_fouls');
                break;
            case 'assist':
                $stat->increment('assists');
                break;
        }

        $two_pt_made = $stat->two_pt_fg_made;
        $three_pt_made = $stat->three_pt_fg_made;
        $two_pt_attempts = $stat->two_pt_fg_attempt;
        $three_pt_attempts = $stat->three_pt_fg_attempt;

        $total_fg_made = $two_pt_made + $three_pt_made;
        $total_fg_attempts = $two_pt_attempts + $three_pt_attempts;

        $eFG_percentage = ($total_fg_attempts > 0) ? (($total_fg_made + 0.5 * $three_pt_made) / $total_fg_attempts) * 100 : 0;
        $stat->effective_field_goal_percentage = $eFG_percentage;
        
        $stat->save();

        // Calculate total scores for both teams
        $schedule = Schedule::findOrFail($validated['schedule_id']);
        $teamAScore = PlayerStat::whereHas('player', function ($query) use ($schedule) {
            $query->where('team_id', $schedule->team1->id);
        })->sum('points');

        $teamBScore = PlayerStat::whereHas('player', function ($query) use ($schedule) {
            $query->where('team_id', $schedule->team2->id);
        })->sum('points');

        PlayByPlay::create([
            'player_id' => $player->id,
            'schedule_id' => $validated['schedule_id'],
            'type_of_stat' => $validated['type_of_stat'],
            'result' => $validated['result'],
            'game_time' => $validated['game_time'],
            'quarter' => $validated['quarter'],
            'team_A_score' => $teamAScore,
            'team_B_score' => $teamBScore
        ]);

        return response()->json([
            'message' => 'Shot recorded successfully',
            'teamAScore' => $teamAScore,
            'teamBScore' => $teamBScore
        ]);
    }

    private function getPoints($type_of_stat, $result) {
        switch ($type_of_stat) {
            case 'two_point':
                return $result === 'made' ? 2 : 0;
            case 'three_point':
                return $result === 'made' ? 3 : 0;
            case 'free_throw':
                return $result === 'made' ? 1 : 0;
            default:
                return 0;
        }
    }
    
    public function show() 
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