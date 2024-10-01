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
        Schema::create('team_stats', function (Blueprint $table) {
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
            $table->unsignedInteger('two_pt_fg_attempt')->default(0);
            $table->unsignedInteger('three_pt_fg_attempt')->default(0);
            $table->unsignedInteger('two_pt_fg_made')->default(0); 
            $table->unsignedInteger('three_pt_fg_made')->default(0); 
            $table->Decimal('two_pt_percentage', 5, 2)->default(0.00); 
            $table->Decimal('three_pt_percentage', 5, 2)->default(0.00);
            $table->unsignedInteger('free_throw_attempt')->default(0);
            $table->unsignedInteger('free_throw_made')->default(0);
            $table->Decimal('free_throw_percentage', 5, 2)->default(0.00);
            $table->Decimal('free_throw_attempt_rate', 5, 2)->default(0.00); 
            $table->Decimal('effective_field_goal_percentage', 5, 2)->default(0.00); 
            $table->Decimal('offensive_rebound_percentage')->default(0.00); 
            $table->Decimal('defensive_rebound_percentage')->default(0.00); 
            $table->Decimal('turnover_ratio')->default(0.00); 
            $table->unsignedInteger('plus_minus')->default(0); 

            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
        
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_stats');
    }
};