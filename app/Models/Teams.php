<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'team_acronym',
        'head_coach_name',
        'school_president',
        'sports_director',
        'years_playing_in_bucal',
        'address',
        'logo',
    ];

    /**
     * Define the relationship with the Tournament model.
     * Each team belongs to one tournament.
     */
    public function tournament()
    {
        return $this->belongsTo(Tournaments::class);
    }

}
