<?php

namespace App\Http\Controllers;

use App\Models\PlayerStat;
use App\Models\Schedule;
use App\Models\tournaments;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{

    public function index(Request $request)
    {
        $tournamentId = $request->input('tournament_id');
        $category = $request->input('category');
    
        // Fetch schedules filtered by the selected tournament and category if provided
        $schedules = Schedule::with(['team1', 'team2']) // Load related teams
            ->when($tournamentId, function ($query) use ($tournamentId) {
                return $query->where('tournament_id', $tournamentId);
            })
            ->when($category, function ($query) use ($category, $tournamentId) {
                return $query->whereHas('team1', function ($q) use ($category, $tournamentId) {
                    $q->where('category', $category)->where('tournament_id', $tournamentId);
                })->orWhereHas('team2', function ($q) use ($category, $tournamentId) {
                    $q->where('category', $category)->where('tournament_id', $tournamentId);
                });
            })
            ->latest()
            ->paginate(25);
    
        $tournaments = Tournaments::all();
    
        $categories = $tournamentId ? $tournaments->where('id', $tournamentId)->pluck('category')->unique() : collect();
    
        return view('analytics.list', [
            'schedules' => $schedules,
            'tournaments' => $tournaments,
            'categories' => $categories,
        ]);
    }

    public function create($schedule_id)
    {
        $schedule = Schedule::with(['team1.players', 'team2.players'])->findOrFail($schedule_id);
        $teams = [$schedule->team1, $schedule->team2];
        $players = $schedule->team1->players->merge($schedule->team2->players);

        $team1Name = $schedule->team1->name; 
        $team2Name = $schedule->team2->name;

        return view('analytics.list', compact('schedule_id', 'teams', 'team1Name', 'team2Name'));
    }

    protected function getTeamsBySchedule($schedule_id)
    {
        // Fetch the schedule along with teams
        $schedule = Schedule::with(['team1', 'team2'])->findOrFail($schedule_id);
        
        // Return the team IDs
        return [$schedule->team1->id, $schedule->team2->id];
    }

    private function formatPlayerName($player)
{
    return $player->first_name[0] . '. ' . $player->last_name; // First letter of first name + last name
}

    public function getChartPointsTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual points scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.points', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    // Debugging output
    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    // Format player names and extract points
    $points = $data->pluck('points')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player); // Use the helper function to format names
    })->toArray();

    // Return points and formatted player names as JSON
    return response()->json(['points' => $points, 'playerNames' => $playerNames]);
}

public function getChartPointsTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual points scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.points', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $points = $data->pluck('points')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['points' => $points, 'playerNames' => $playerNames]);
}


public function getChartAssistsTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual assists scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.assists', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $assists = $data->pluck('assists')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['assists' => $assists, 'playerNames' => $playerNames]);
}


public function getChartAssistsTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual assists scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.assists', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $assists = $data->pluck('assists')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['assists' => $assists, 'playerNames' => $playerNames]);
}


public function getChartReboundsTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual rebounds scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.rebounds', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $rebounds = $data->pluck('rebounds')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['rebounds' => $rebounds, 'playerNames' => $playerNames]);
}


public function getChartReboundsTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual rebounds scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.rebounds', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $rebounds = $data->pluck('rebounds')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['rebounds' => $rebounds, 'playerNames' => $playerNames]);
}


public function getChartStealsTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual steals scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.steals', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $steals = $data->pluck('steals')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['steals' => $steals, 'playerNames' => $playerNames]);
}


public function getChartStealsTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual steals scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.steals', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $steals = $data->pluck('steals')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['steals' => $steals, 'playerNames' => $playerNames]);
}

public function getChartBlocksTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual blocks scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.blocks', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $blocks = $data->pluck('blocks')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['blocks' => $blocks, 'playerNames' => $playerNames]);
}

public function getChartBlocksTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual blocks scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.blocks', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $blocks = $data->pluck('blocks')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['blocks' => $blocks, 'playerNames' => $playerNames]);
}

public function getChartPerFoulTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual personal fouls scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.personal_fouls', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $personal_fouls = $data->pluck('personal_fouls')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['personal_fouls' => $personal_fouls, 'playerNames' => $playerNames]);
}

public function getChartPerFoulTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual personal fouls scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.personal_fouls', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $personal_fouls = $data->pluck('personal_fouls')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['personal_fouls' => $personal_fouls, 'playerNames' => $playerNames]);
}

public function getChartTurnoversTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual turnovers scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.turnovers', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $turnovers = $data->pluck('turnovers')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['turnovers' => $turnovers, 'playerNames' => $playerNames]);
}

public function getChartTurnoversTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual turnovers scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.turnovers', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $turnovers = $data->pluck('turnovers')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['turnovers' => $turnovers, 'playerNames' => $playerNames]);
}

public function getChartOReboundsTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual offensive rebounds scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.offensive_rebounds', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $offensive_rebounds = $data->pluck('offensive_rebounds')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['offensive_rebounds' => $offensive_rebounds, 'playerNames' => $playerNames]);
}

public function getChartOReboundsTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual offensive rebounds scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.offensive_rebounds', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $offensive_rebounds = $data->pluck('offensive_rebounds')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['offensive_rebounds' => $offensive_rebounds, 'playerNames' => $playerNames]);
}

public function getChartDReboundsTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual defensive rebounds scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.defensive_rebounds', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $defensive_rebounds = $data->pluck('defensive_rebounds')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['defensive_rebounds' => $defensive_rebounds, 'playerNames' => $playerNames]);
}

public function getChartDReboundsTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual defensive rebounds scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.defensive_rebounds', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $defensive_rebounds = $data->pluck('defensive_rebounds')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['defensive_rebounds' => $defensive_rebounds, 'playerNames' => $playerNames]);
}

public function getChartTwoPointFGAttemptTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual Two Point FG Attempt scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.two_pt_fg_attempt', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $two_pt_fg_attempt = $data->pluck('two_pt_fg_attempt')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['two_pt_fg_attempt' => $two_pt_fg_attempt, 'playerNames' => $playerNames]);
}

public function getChartTwoPointFGAttemptTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual Two Point FG Attempt scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.two_pt_fg_attempt', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $two_pt_fg_attempt = $data->pluck('two_pt_fg_attempt')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['two_pt_fg_attempt' => $two_pt_fg_attempt, 'playerNames' => $playerNames]);
}

public function getChartTwoPointFGMadeTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual Two Point FG Made scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.two_pt_fg_made', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $two_pt_fg_made = $data->pluck('two_pt_fg_made')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['two_pt_fg_made' => $two_pt_fg_made, 'playerNames' => $playerNames]);
}

public function getChartTwoPointFGMadeTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual Two Point FG Made scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.two_pt_fg_made', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $two_pt_fg_made = $data->pluck('two_pt_fg_made')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['two_pt_fg_made' => $two_pt_fg_made, 'playerNames' => $playerNames]);
}

public function getChartThreePointFGAttemptTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual Three Point FG Attempt scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.three_pt_fg_attempt', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $three_pt_fg_attempt = $data->pluck('three_pt_fg_attempt')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['three_pt_fg_attempt' => $three_pt_fg_attempt, 'playerNames' => $playerNames]);
}

public function getChartThreePointFGAttemptTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual Three Point FG Attempt scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.three_pt_fg_attempt', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $three_pt_fg_attempt = $data->pluck('three_pt_fg_attempt')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['three_pt_fg_attempt' => $three_pt_fg_attempt, 'playerNames' => $playerNames]);
}

public function getChartThreePointFGMadeTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual Three Point FG Made scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.three_pt_fg_made', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $three_pt_fg_made = $data->pluck('three_pt_fg_made')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['three_pt_fg_made' => $three_pt_fg_made, 'playerNames' => $playerNames]);
}

public function getChartThreePointFGMadeTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual Three Point FG Made scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.three_pt_fg_made', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $three_pt_fg_made = $data->pluck('three_pt_fg_made')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['three_pt_fg_made' => $three_pt_fg_made, 'playerNames' => $playerNames]);
}

public function getChartTwoPointPercentageTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual Two Point Percentage scored by players in Team A with their names
    $data = PlayerStat::select('player_stats.two_pt_percentage', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $two_pt_percentage = $data->pluck('two_pt_percentage')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['two_pt_percentage' => $two_pt_percentage, 'playerNames' => $playerNames]);
}

public function getChartTwoPointPercentageTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    // Fetch individual Two Point Percentage scored by players in Team B with their names
    $data = PlayerStat::select('player_stats.two_pt_percentage', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $two_pt_percentage = $data->pluck('two_pt_percentage')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['two_pt_percentage' => $two_pt_percentage, 'playerNames' => $playerNames]);
}

public function getChartThreePointPercentageTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.three_pt_percentage', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $three_pt_percentage = $data->pluck('three_pt_percentage')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['three_pt_percentage' => $three_pt_percentage, 'playerNames' => $playerNames]);
}

public function getChartThreePointPercentageTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.three_pt_percentage', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $three_pt_percentage = $data->pluck('three_pt_percentage')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['three_pt_percentage' => $three_pt_percentage, 'playerNames' => $playerNames]);
}

public function getChartFreeThrowAttemptTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.free_throw_attempt', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $free_throw_attempt = $data->pluck('free_throw_attempt')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['free_throw_attempt' => $free_throw_attempt, 'playerNames' => $playerNames]);
}

public function getChartFreeThrowAttemptTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.free_throw_attempt', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $free_throw_attempt = $data->pluck('free_throw_attempt')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['free_throw_attempt' => $free_throw_attempt, 'playerNames' => $playerNames]);
}


public function getChartFreeThrowMadeTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.free_throw_made', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $free_throw_made = $data->pluck('free_throw_made')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['free_throw_made' => $free_throw_made, 'playerNames' => $playerNames]);
}

public function getChartFreeThrowMadeTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.free_throw_made', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $free_throw_made = $data->pluck('free_throw_made')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['free_throw_made' => $free_throw_made, 'playerNames' => $playerNames]);
}

public function getChartFreeThrowPercentageTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.free_throw_percentage', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $free_throw_percentage = $data->pluck('free_throw_percentage')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['free_throw_percentage' => $free_throw_percentage, 'playerNames' => $playerNames]);
}

public function getChartFreeThrowPercentageTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.free_throw_percentage', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $free_throw_percentage = $data->pluck('free_throw_percentage')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['free_throw_percentage' => $free_throw_percentage, 'playerNames' => $playerNames]);
}

public function getChartFreeThrowAttemptRateTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.free_throw_attempt_rate', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $free_throw_attempt_rate = $data->pluck('free_throw_attempt_rate')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['free_throw_attempt_rate' => $free_throw_attempt_rate, 'playerNames' => $playerNames]);
}

public function getChartFreeThrowAttemptRateTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.free_throw_attempt_rate', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $free_throw_attempt_rate = $data->pluck('free_throw_attempt_rate')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['free_throw_attempt_rate' => $free_throw_attempt_rate, 'playerNames' => $playerNames]);
}

public function getChartPlusMinusTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.plus_minus', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $plus_minus = $data->pluck('plus_minus')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['plus_minus' => $plus_minus, 'playerNames' => $playerNames]);
}

public function getChartPlusMinusTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.plus_minus', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $plus_minus = $data->pluck('plus_minus')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['plus_minus' => $plus_minus, 'playerNames' => $playerNames]);
}

public function getChartEffectiveFieldGoalPercentageTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.effective_field_goal_percentage', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $effective_field_goal_percentage = $data->pluck('effective_field_goal_percentage')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['effective_field_goal_percentage' => $effective_field_goal_percentage, 'playerNames' => $playerNames]);
}

public function getChartEffectiveFieldGoalPercentageTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.effective_field_goal_percentage', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $effective_field_goal_percentage = $data->pluck('effective_field_goal_percentage')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['effective_field_goal_percentage' => $effective_field_goal_percentage, 'playerNames' => $playerNames]);
}

public function getChartTurnoverRatioTeamA($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.turnover_ratio', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamAId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team A']);
    }

    $turnover_ratio = $data->pluck('turnover_ratio')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['turnover_ratio' => $turnover_ratio, 'playerNames' => $playerNames]);
}

public function getChartTurnoverRatioTeamB($schedule_id)
{
    list($teamAId, $teamBId) = $this->getTeamsBySchedule($schedule_id);

    $data = PlayerStat::select('player_stats.turnover_ratio', 'players.first_name', 'players.last_name')
        ->join('players', 'players.id', '=', 'player_stats.player_id')
        ->where('player_stats.team_id', $teamBId)
        ->where('player_stats.schedule_id', $schedule_id)
        ->orderBy('players.last_name')
        ->get();

    if ($data->isEmpty()) {
        return response()->json(['message' => 'No data available for Team B']);
    }

    $turnover_ratio = $data->pluck('turnover_ratio')->toArray();
    $playerNames = $data->map(function ($player) {
        return $this->formatPlayerName($player);
    })->toArray();

    return response()->json(['turnover_ratio' => $turnover_ratio, 'playerNames' => $playerNames]);
}
}
