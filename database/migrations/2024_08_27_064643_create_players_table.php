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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable(); 
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('number');
            $table->integer('years_playing_in_bucal');
            $table->string('position');
            $table->date('date_of_birth')->nullable();
            $table->integer('age')->nullable();
            $table->string('height')->nullable();
            $table->integer('weight')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('team_id');

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
