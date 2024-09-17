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

    public function player()
    {
        return $this->belongsTo(Players::class);
    }

    // Relationship with Game
    public function game()
    {
        return $this->belongsTo(Schedule::class);
    }
}
