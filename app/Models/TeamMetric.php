<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teams;
use App\Models\Schedule;

class TeamMetric extends Model
{
    use HasFactory;

    protected $table = 'team_metrics';

    protected $fillable = [
        'schedule_id',
        'team_id',
        'points_off_turnover',
        'fast_break_points',
        'second_chance_points',
        'starter_points',
        'bench_points',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function team()
    {
        return $this->belongsTo(Teams::class);
    }
}
