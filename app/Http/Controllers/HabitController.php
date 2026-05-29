<?php
// app/Http/Controllers/HabitController.php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HabitController extends Controller
{
    // Halaman utama / dashboard
    public function index()
    {
        // Hanya tampilkan habit yang is_permanent = true ATAU yang ada log untuk hari ini
        $habits = Habit::where(function($query) {
            $query->where('is_permanent', true)
                  ->orWhereHas('logs', function($q) {
                      $q->where('date', today());
                  });
        })->get();
        
        // Ambil logs hari ini
        $todayLogs = HabitLog::where('date', today())
            ->pluck('completed', 'habit_id')
            ->toArray();
        
        // Hitung progress hari ini (hitung dari habit yang tampil)
        $totalHabits = $habits->count();
        $completedToday = collect($todayLogs)->filter()->count();
        $todayPercentage = $totalHabits > 0 ? round(($completedToday / $totalHabits) * 100, 2) : 0;
        
        return view('habits.index', compact('habits', 'todayLogs', 'todayPercentage'));
    }
    
    // Toggle centang habit (klik untuk centang/batal)
    public function toggle(Habit $habit)
    {
        // Cari atau buat log untuk hari ini
        $log = HabitLog::firstOrCreate([
            'habit_id' => $habit->id,
            'date' => today(),
        ]);
        
        // Balik status completed
        $log->completed = !$log->completed;
        $log->save();
        
        return response()->json([
            'success' => true, 
            'completed' => $log->completed
        ]);
    }
    
    // Tambah habit baru (TEMPORARY - hanya untuk hari ini)
// Tambah habit baru (TEMPORARY - hanya untuk hari ini)
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255'
    ]);
    
    // Cek apakah habit sudah ada
    $existingHabit = Habit::where('name', $request->name)->first();
    
    if ($existingHabit) {
        $habit = $existingHabit;
    } else {
        // Buat habit baru dengan is_permanent = false (temporary)
        $habit = Habit::create([
            'name' => $request->name,
            'is_permanent' => false
        ]);
    }
    
    // Otomatis buat log untuk hari ini (belum dicentang)
    HabitLog::firstOrCreate([
        'habit_id' => $habit->id,
        'date' => today(),
    ]);
    
    return redirect()->route('habits.index')->with('success', 'Habit tambahan berhasil ditambahkan (hanya untuk hari ini)');
}
    
    // Hapus habit
    public function destroy(Habit $habit)
    {
        // Jika habit temporary, hapus permanent
        // Jika habit permanent, jangan biarkan dihapus
        if (!$habit->is_permanent) {
            $habit->forceDelete();
        } else {
            $habit->delete(); // soft delete jika pakai softdeletes
        }
        
        return redirect()->route('habits.index')->with('success', 'Habit dihapus');
    }
    
    // Halaman history
    public function history()
    {
        $habits = Habit::all(); // Tampilkan semua habit untuk statistik
        
        // Ambil semua logs, urutkan dari yang terbaru
        $logs = HabitLog::with('habit')
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('date');
        
        // Statistik per hari
        $dailyStats = [];
        foreach ($logs as $date => $dailyLogs) {
            $total = $dailyLogs->count();
            $completed = $dailyLogs->where('completed', true)->count();
            $dailyStats[$date] = [
                'percentage' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
                'logs' => $dailyLogs
            ];
        }
        
        // Statistik 7 hari terakhir
        $weeklyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyLogs = HabitLog::where('date', $date)->get();
            $total = $habits->count();
            $completed = $dailyLogs->where('completed', true)->count();
            $weeklyStats[$date->format('Y-m-d')] = [
                'percentage' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
                'completed' => $completed,
                'total' => $total
            ];
        }
        
        // Statistik per habit
        $habitStats = [];
        foreach ($habits as $habit) {
            $totalLogs = $habit->logs()->count();
            $completedLogs = $habit->logs()->where('completed', true)->count();
            $habitStats[$habit->id] = [
                'name' => $habit->name,
                'icon' => $habit->icon,
                'is_permanent' => $habit->is_permanent,
                'total_days' => $totalLogs,
                'completed_days' => $completedLogs,
                'percentage' => $totalLogs > 0 ? round(($completedLogs / $totalLogs) * 100, 2) : 0
            ];
        }
        
        return view('habits.history', compact('logs', 'dailyStats', 'weeklyStats', 'habitStats'));
    }
    
    // Tambah method untuk cleanup habit temporary setiap hari (optional - bisa pakai scheduler)
    public function cleanupTemporaryHabits()
    {
        // Hapus habit temporary yang tidak memiliki log dalam 7 hari terakhir
        $weekAgo = now()->subDays(7);
        
        Habit::where('is_permanent', false)
            ->whereDoesntHave('logs', function($query) use ($weekAgo) {
                $query->where('date', '>=', $weekAgo);
            })
            ->forceDelete();
            
        return "Cleanup selesai";
    }
}