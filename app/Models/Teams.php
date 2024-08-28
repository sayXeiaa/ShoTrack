<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    use HasFactory;

    /**
     * Define the relationship with the Tournament model.
     * Each team belongs to one tournament.
     */
    public function tournament()
    {
        return $this->belongsTo(Tournaments::class);
    }

}
