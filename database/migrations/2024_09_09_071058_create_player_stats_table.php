<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('player_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('minutes')->default(0);
            $table->unsignedInteger('points')->default(0);
            $table->unsignedInteger('rebounds')->default(0);
            $table->unsignedInteger('assists')->default(0);
            $table->unsignedInteger('steals')->default(0);
            $table->unsignedInteger('blocks')->default(0);
            $table->unsignedInteger('personal_fouls')->default(0);
            $table->unsignedInteger('turnovers')->default(0);
            $table->unsignedInteger('offensive_rebounds')->default(0);
            $table->unsignedInteger('defensive_rebounds')->default(0);
            $table->unsignedInteger('2pt_fg_attempt')->default(0);
            $table->unsignedInteger('3pt_fg_attempt')->default(0);
            $table->unsignedInteger('2pt_fg_made')->default(0); 
            $table->unsignedDecimal('2pt_percentage', 5, 2)->default(0.00); 
            $table->unsignedDecimal('3pt_percentage', 5, 2)->default(0.00);
            $table->unsignedInteger('free_throw_attempt')->default(0);
            $table->unsignedInteger('free_throw_made')->default(0);
            $table->unsignedDecimal('free_throw_percentage', 5, 2)->default(0.00);
            $table->unsignedDecimal('free_throw_attempt_rate', 5, 2)->default(0.00); 
            $table->integer('plus_minus')->default(0); 
            $table->unsignedDecimal('effective_field_goal_percentage', 5, 2)->default(0.00); 
        
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade'); 
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
        
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_stats');
    }
};
