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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable(); 
            $table->string('name');
            $table->string('team_acronym');
            $table->string('head_coach_name');
            $table->string('school_president');
            $table->string('sports_director');
            $table->integer('years_playing_in_bucal');
            $table->string('address');
            $table->string('logo')->nullable();
            $table->integer('wins')->default(0);
            $table->integer('losses')->default(0);
            $table->integer('ranking')->nullable();
            $table->timestamps();
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade'); // Foreign key to tournaments
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
