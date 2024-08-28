<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    use HasFactory;

    public function team()
    {
        return $this->belongsTo(Teams::class);
    }

    /**
     * Get the tournament through the team.
     */
    public function tournament()
    {
        return $this->hasOneThrough(Tournaments::class, Teams::class, 'id', 'id', 'team_id', 'tournament_id');
    }
    
}
