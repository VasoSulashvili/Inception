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
            $table->unsignedBigInteger('rank_id')->unique();
            $table->string('username')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('lang');
            $table->decimal('balance', 40, 4)->default(0.0000);
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_blocked')->default(0);
            $table->boolean('active')->index()->default(1);
            $table->softDeletes();
            $table->dateTime('spinner_last_activity')->nullable();
            $table->timestamps();

            $table->foreign('rank_id')
                ->references('id')
                ->on('ranks')
                ->onDelete('restrict');
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
