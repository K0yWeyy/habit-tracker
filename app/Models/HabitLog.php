<?php
// app/Models/HabitLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitLog extends Model
{
    protected $fillable = ['habit_id', 'date', 'completed'];
    
    protected $casts = [
        'date' => 'date',
        'completed' => 'boolean',
    ];
    
    // Relasi ke table habits
    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }
}