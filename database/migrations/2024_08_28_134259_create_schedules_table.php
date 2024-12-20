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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->string('venue');
            $table->integer('remaining_game_time')->default(0);
            $table->integer('total_elapsed_time')->default(0);
            $table->integer('quarter_elapsed_time')->default(0);
            $table->integer('current_quarter')->default(0);
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
            $table->foreignId('tournament_id')->constrained('tournaments');
            $table->foreignId('team1_id')->constrained('teams')->onDelete('cascade');;
            $table->foreignId('team2_id')->constrained('teams')->onDelete('cascade');;
            $table->string('category')->nullable(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
