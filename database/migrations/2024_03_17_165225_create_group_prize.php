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
        Schema::create('group_prize', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('prize_id');
            $table->integer('number');
            $table->decimal('amount', 40, 4)->default(0.0001);
            $table->timestamps();

            $table->unique(['group_id', 'prize_id']);
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('prize_id')->references('id')->on('prizes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_prize');
    }
};
