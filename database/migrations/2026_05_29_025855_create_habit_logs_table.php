<?php
// database/migrations/2024_01_01_000002_create_habit_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('habit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habit_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->boolean('completed')->default(false);
            $table->timestamps();
            
            $table->unique(['habit_id', 'date']); // biar 1 habit cuma 1x per hari
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('habit_logs');
    }
};