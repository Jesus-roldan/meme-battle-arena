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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('battle_id')->constrained('battles')->onDelete('cascade');
            $table->foreignId('meme_id')->constrained('memes')->onDelete('cascade');
            $table->timestamps();

            // Evita que un usuario vote más de una vez en la misma battle
            $table->unique(['user_id', 'battle_id']);

            // Índices para consultas rápidas
            $table->index('user_id');
            $table->index('meme_id');
            $table->index('battle_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
