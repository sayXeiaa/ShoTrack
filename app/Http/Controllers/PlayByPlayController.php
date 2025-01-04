<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\ScheduleTestCommand;
use Illuminate\Http\Request;
use App\Models\PlayerStat;
use App\Models\PlayByPlay;
use App\Models\Players;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\DB;
class PlayByPlayController extends Controller
{

    private function formatPlayerName($player)
    {
        return $player->first_name[0] . '. ' . $player->last_name;
    }

    private function getActionText($type_of_stat, $result)
    {
        switch ($type_of_stat) {
            case 'two_point':
                return $result === 'made' ? 'MADE a 2-point field goal' : 'MISSED a 2-point field goal';
            case 'three_point':
                return $result === 'made' ? 'MADE a 3-point field goal' : 'MISSED a 3-point field goal';
            case 'free_throw':
                return $result === 'made' ? 'MADE a free throw' : 'MISSED a free throw';
            case 'offensive_rebound':
                return 'Grabbed an offensive rebound';
            case 'defensive_rebound':
                return 'Grabbed a defensive rebound';
            case 'block':
                return 'Blocked a shot';
            case 'steal':
                return 'Stole the ball';
            case 'turnover':
                return 'Committed a turnover';
            case 'foul':
                return 'Committed a foul';
            case 'assist':
                return 'MADE an assist';
            case 'technical_foul':
                return 'Committed a Technical Foul';
            case 'unsportsmanlike_foul':
                return 'Committed an Unsportsmanlike Foul';
            case 'disqualifying_foul':
                return 'Committed a Disqualifying Foul';
            default:
                return 'Unknown action';
        }
    }

    private function getPoints($type_of_stat, $result) {
        switch ($type_of_stat) {
            case 'two_point':
                return $result === 'made' ? 2 : 0;
            case 'three_point':
                return $result === 'made' ? 3 : 0;
            case 'free_throw':
                return $result === 'made' ? 1 : 0;
            case 'assist':
            case 'offensive_rebound':
            case 'defensive_rebound':
            case 'steal':
            case 'block':
            case 'foul':
            case 'technical_foul':
            case 'unsportsmanlike_foul':
            case 'disqualifying_foul':
                return 0; 
            default:
                return 0;
        }
    }

    public function getPlayByPlay($scheduleId)
    {
        // Fetch the play-by-play data from the play_by_play table
        $entries = PlayByPlay::where('schedule_id', $scheduleId)
                            ->orderBy('created_at', 'asc')
                            ->get();

        // Debug the retrieved entries
        Log::info('Retrieved play-by-play data:', $entries->toArray());

        // Format the data
        $formattedEntries = $entries->map(function ($stat) {
            $formattedName = $this->formatPlayerName($stat->player); 
            $action = $this->getActionText($stat->type_of_stat, $stat->result);
            $points = $this->getPoints($stat->type_of_stat, $stat->result); 
            return [
                'player_number' => $stat->player->number,
                'game_time' => $stat->game_time,
                'player_name' => $formattedName,
                'type_of_stat' => $stat->type_of_stat, 
                'action' => $action,
                'points' => $points,
                'team_A_score' => $stat->team_A_score, 
                'team_B_score' => $stat->team_B_score, 
            ];
        });

        // Return the play-by-play data
        return response()->json([
            'play_by_play' => $formattedEntries,
        ]);
    }

    public function getTeamFouls($scheduleId, $quarter)
    {
        $teamFouls = PlayByPlay::where('schedule_id', $scheduleId)
            ->where('quarter', $quarter)
            ->whereIn('type_of_stat', ['foul', 'technical_foul', 'unsportsmanlike_foul', 'disqualifying_foul'])
            ->join('players', 'play_by_plays.player_id', '=', 'players.id')
            ->select('players.team_id', DB::raw('COUNT(play_by_plays.id) as fouls'))
            ->groupBy('players.team_id')
            ->get();

        $schedule = Schedule::with(['team1', 'team2'])->find($scheduleId);

        // Initialize response with 0 fouls for both teams
        $response = [
            'team_1' => $schedule->team1_id ?? null,
            'team_1_fouls' => 0,
            'team_2' => $schedule->team2_id ?? null,
            'team_2_fouls' => 0,
        ];

        foreach ($teamFouls as $foul) {
            if ($foul->team_id == $response['team_1']) {
                $response['team_1_fouls'] = $foul->fouls;
            } elseif ($foul->team_id == $response['team_2']) {
                $response['team_2_fouls'] = $foul->fouls;
            }
        }

        return response()->json($response);
    }
}