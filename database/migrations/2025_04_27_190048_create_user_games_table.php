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
        Schema::create('user_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_id')->constrained()->onDelete('cascade');

            $table->enum('state', ['playing', 'completed', 'dropped', 'wishlist', 'planned', 'backlog'])->default('planned');

            $table->boolean('mastered')->default(false);
            $table->tinyInteger('user_score')->nullable();

            $table->text('comment')->nullable();

            $table->float('progress')->default(0);

            $table->integer('achievements_unlocked')->default(0);

            $table->float('hours_played')->default(0);

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->timestamps();
            $table->unique(['user_id', 'game_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_games');
    }
};
