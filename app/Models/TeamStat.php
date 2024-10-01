<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\PlayerStat;

class TeamStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'minutes',
        'points',
        'rebounds',
        'assists',
        'steals',
        'blocks',
        'personal_fouls',
        'turnovers',
        'offensive_rebounds',
        'defensive_rebounds',
        'offensive_rebound_percentage',
        'defensive_rebound_percentage',
        'two_pt_fg_attempt',
        'three_pt_fg_attempt',
        'two_pt_fg_made',
        'three_pt_fg_made',
        'two_pt_percentage',
        'three_pt_percentage',
        'free_throw_attempt',
        'free_throw_made',
        'free_throw_percentage',
        'free_throw_attempt_rate',
        'effective_field_goal_percentage',
        'turnover_ratio',
        'schedule_id',
        'team_id'
    ];

    public function team()
    {
        return $this->belongsTo(Teams::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public static function updateStatsForTeam($teamId, $scheduleId)
    {
        // Fetch all players for the given team
        $players = Players::where('team_id', $teamId)->get();
    
        // Initialize total stats
        $totalMinutes = 0;
        $totalPoints = 0;
        $totalRebounds = 0;
        $totalAssists = 0;
        $totalSteals = 0;
        $totalBlocks = 0;
        $totalFouls = 0;
        $totalTurnovers = 0;
        $totalOffensiveRebounds = 0;
        $totalDefensiveRebounds = 0;
        $total2ptFgMade = 0;
        $total2ptFgAttempt = 0;
        $totalFreeThrowMade = 0;
        $totalFreeThrowAttempt = 0;

    
        // Initialize arrays to hold percentages for each unique schedule
        $offensiveReboundPercentages = [];
        $defensiveReboundPercentages = [];
    
        // Fetch unique schedule IDs for the team
        $uniqueSchedules = PlayerStat::whereIn('player_id', $players->pluck('id'))
            ->distinct('schedule_id')
            ->pluck('schedule_id');
    
        // Fetch stats for each schedule
        foreach ($uniqueSchedules as $scheduleId) {
    
            // Fetch stats for each player
            foreach ($players as $player) {
                $stats = PlayerStat::where('player_id', $player->id)
                    ->where('schedule_id', $scheduleId)
                    ->first();
    
                if ($stats) {
                    $totalMinutes += $stats->minutes;
                    $totalPoints += $stats->points;
                    $totalRebounds += $stats->rebounds;
                    $totalAssists += $stats->assists;
                    $totalSteals += $stats->steals;
                    $totalBlocks += $stats->blocks;
                    $totalFouls += $stats->personal_fouls;
                    $totalTurnovers += $stats->turnovers;
                    $total2ptFgMade += $stats->two_pt_fg_made;
                    $total2ptFgAttempt +=$stats->two_pt_fg_attempt;
                    $totalOffensiveRebounds += $stats->offensive_rebounds;
                    $totalDefensiveRebounds += $stats->defensive_rebounds;
                    $totalFreeThrowMade += $stats->free_throw_made;
                    $totalFreeThrowAttempt += $stats->free_throw_attempt;

                }
            }
    
            // Field Goals totals for this schedule
    
            $total3ptFgMade = PlayerStat::whereIn('player_id', $players->pluck('id'))
                ->where('schedule_id', $scheduleId)
                ->sum('three_pt_fg_made');
    
            $total3ptFgAttempt = PlayerStat::whereIn('player_id', $players->pluck('id'))
                ->where('schedule_id', $scheduleId)
                ->sum('three_pt_fg_attempt');
    
            // Calculate opponent rebounds
            $opponentDefensiveRebounds = self::getOpponentDefensiveRebounds($teamId, $scheduleId);
            $opponentOffensiveRebounds = self::getOpponentOffensiveRebounds($teamId, $scheduleId);
    
            // Calculate percentages for this schedule
            $offensiveReboundPercentage = $totalOffensiveRebounds > 0 ? 
                ($totalOffensiveRebounds / ($totalOffensiveRebounds + $opponentDefensiveRebounds)) * 100 : 0;
    
            $defensiveReboundPercentage = $totalDefensiveRebounds > 0 ? 
                ($totalDefensiveRebounds / ($opponentOffensiveRebounds + $totalDefensiveRebounds)) * 100 : 0;
    
            // Store the percentages
            $offensiveReboundPercentages[] = $offensiveReboundPercentage;
            $defensiveReboundPercentages[] = $defensiveReboundPercentage;
        }
    
        // Calculate averages
        $averageOffensiveReboundPercentage = count($offensiveReboundPercentages) > 0 ? 
            array_sum($offensiveReboundPercentages) / count($offensiveReboundPercentages) : 0;
    
        $averageDefensiveReboundPercentage = count($defensiveReboundPercentages) > 0 ? 
            array_sum($defensiveReboundPercentages) / count($defensiveReboundPercentages) : 0;
    
        $twoPtPercentage = $total2ptFgAttempt > 0 ? 
            ($total2ptFgMade / $total2ptFgAttempt) * 100 : 0;
    
        $threePtPercentage = $total3ptFgAttempt > 0 ? 
            ($total3ptFgMade / $total3ptFgAttempt) * 100 : 0;
    
        $freeThrowPercentage = $totalFreeThrowAttempt > 0 ? 
            ($totalFreeThrowMade / $totalFreeThrowAttempt) * 100 : 0;
    
        $totalFgAttempt = $total2ptFgAttempt + $total3ptFgAttempt;
        $freeThrowAttemptRate = $totalFgAttempt > 0 ? 
            ($totalFreeThrowAttempt / $totalFgAttempt) * 100 : 0;
    
        $effectiveFieldGoalPercentage = $totalFgAttempt > 0 ? 
            (($total2ptFgMade + 0.5 * $total3ptFgMade) / $totalFgAttempt) * 100 : 0;
    
        $turnover_ratio = ($totalFgAttempt + ($totalFreeThrowAttempt * 0.44) + $totalAssists + $totalTurnovers) > 0
            ? ($totalTurnovers * 100) / ($totalFgAttempt + ($totalFreeThrowAttempt * 0.44) + $totalAssists + $totalTurnovers)
            : 0;
    
        // Update team stats
        $result = self::updateOrCreate(
            ['team_id' => $teamId], // Only filter by team_id
            [
                'minutes' => $totalMinutes,
                'points' => $totalPoints,
                'rebounds' => $totalRebounds,
                'assists' => $totalAssists,
                'steals' => $totalSteals,
                'blocks' => $totalBlocks,
                'personal_fouls' => $totalFouls,
                'turnovers' => $totalTurnovers,
                'offensive_rebounds' => $totalOffensiveRebounds,
                'defensive_rebounds' => $totalDefensiveRebounds,
                'two_pt_fg_made' => $total2ptFgMade,
                'two_pt_fg_attempt' => $total2ptFgAttempt,
                'three_pt_fg_made' => $total3ptFgMade,
                'three_pt_fg_attempt' => $total3ptFgAttempt,
                'free_throw_made' => $totalFreeThrowMade,
                'free_throw_attempt' => $totalFreeThrowAttempt,
                'offensive_rebound_percentage' => $averageOffensiveReboundPercentage,
                'defensive_rebound_percentage' => $averageDefensiveReboundPercentage,
                'two_pt_percentage' => $twoPtPercentage,
                'three_pt_percentage' => $threePtPercentage,
                'free_throw_percentage' => $freeThrowPercentage,
                'free_throw_attempt_rate' => $freeThrowAttemptRate,
                'turnover_ratio' => $turnover_ratio,
                'effective_field_goal_percentage' => $effectiveFieldGoalPercentage
            ]
        );
        Log::info('Update or Create Result:', ['result' => $result]);
    }

    public static function getOpponentDefensiveRebounds($teamId, $scheduleId)
    {
        // Assuming you have a Schedule model with a relation to teams
        $schedule = Schedule::find($scheduleId);
        if (!$schedule) {
            return 0; // Return 0 if schedule is not found
        }

        // Determine the opponent team ID
        $opponentTeamId = $schedule->team1_id === $teamId ? $schedule->team2_id : $schedule->team1_id;

        // Fetch defensive rebounds for the opponent team
        $opponentStats = self::where('team_id', $opponentTeamId)->first();

        return $opponentStats ? $opponentStats->defensive_rebounds : 0; // Return 0 if no stats found
    }

    public static function getOpponentOffensiveRebounds($teamId, $scheduleId)
    {
        // Assuming you have a Schedule model with a relation to teams
        $schedule = Schedule::find($scheduleId);
        if (!$schedule) {
            return 0; // Return 0 if schedule is not found
        }

        // Determine the opponent team ID
        $opponentTeamId = $schedule->team1_id === $teamId ? $schedule->team2_id : $schedule->team1_id;

        // Fetch offensive rebounds for the opponent team
        $opponentStats = self::where('team_id', $opponentTeamId)->first();

        return $opponentStats ? $opponentStats->offensive_rebounds : 0; // Return 0 if no stats found
    }

}