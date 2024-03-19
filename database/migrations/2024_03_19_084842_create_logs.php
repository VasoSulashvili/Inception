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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('prize_id');
            $table->string('action')->index();
            $table->json('player_data');
            $table->json('prize_data');
            $table->dateTime('won_at')->default(now());
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('prize_id')->references('id')->on('prizes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
