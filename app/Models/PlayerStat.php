<?php

namespace App\Models;

use App\Http\Controllers\PlayerStatsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Players;
use App\Models\Schedule;

class PlayerStat extends Model
{
    use HasFactory;

    protected $table = 'player_stats';
    protected $fillable = [
        'player_id',
        'schedule_id',
        'team_id', // Ensure this column exists in your migration
        'points',
        'two_pt_fg_attempt',
        'two_pt_fg_made',
        'two_pt_percentage',
        'three_pt_fg_attempt',
        'three_pt_fg_made',
        'three_pt_percentage',
        'free_throw_attempt',
        'free_throw_made',
        'free_throw_percentage',
        'free_throw_attempt_rate',
        'rebounds',
        'offensive_rebounds',
        'defensive_rebounds',
        'assists',
        'blocks',
        'steals',
        'turnovers',
        'personal_fouls',
        'effective_field_goal_percentage',
        'minutes',
    ];

    public function player()
    {
        return $this->belongsTo(Players::class, 'player_id');
    }

    // Relationship with Game
    public function game()
    {
        return $this->belongsTo(Schedule::class);
    }
}
