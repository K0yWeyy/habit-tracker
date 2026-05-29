<?php
// app/Models/Habit.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    protected $fillable = ['name', 'icon', 'is_permanent'];
    
    protected $casts = [
        'is_permanent' => 'boolean',
    ];
    
    // Relasi ke table habit_logs
    public function logs()
    {
        return $this->hasMany(HabitLog::class);
    }
    
    // Ambil log untuk hari ini
    public function getTodayLog()
    {
        return $this->logs()->where('date', today())->first();
    }
    
    // Hitung persentase completion
    public function getCompletionPercentage($startDate = null, $endDate = null)
    {
        $query = $this->logs();
        
        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }
        
        $total = $query->count();
        if ($total === 0) return 0;
        
        $completed = $query->where('completed', true)->count();
        return round(($completed / $total) * 100, 2);
    }
}