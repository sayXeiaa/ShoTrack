<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayerStat;
use App\Models\PlayByPlay;
use Illuminate\Support\Facades\Log; 
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
                return 0; // These do not contribute to the score
            default:
                return 0;
        }
    }

    public function getPlayByPlay($scheduleId)
    {
        // Fetch the play-by-play data from the play_by_play table
        $entries = PlayByPlay::where('schedule_id', $scheduleId)
                            ->orderBy('created_at', 'asc') // Order by ascending to reflect the game flow
                            ->get();

        // Debug the retrieved entries
        Log::info('Retrieved play-by-play data:', $entries->toArray());

        // Format the data
        $formattedEntries = $entries->map(function ($stat) {
            $formattedName = $this->formatPlayerName($stat->player); 
            $action = $this->getActionText($stat->type_of_stat, $stat->result);
            $points = $this->getPoints($stat->type_of_stat, $stat->result); // Get points for the stat
            return [
                'game_time' => $stat->game_time,
                'player_name' => $formattedName,
                'type_of_stat' => $stat->type_of_stat, 
                'action' => $action,
                'points' => $points,
                'team_A_score' => $stat->team_A_score, // Individual score for Team A
                'team_B_score' => $stat->team_B_score, // Individual score for Team B
            ];
        });

        // Return the play-by-play data
        return response()->json([
            'play_by_play' => $formattedEntries,
        ]);
    }

}