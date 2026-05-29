<?php

namespace Database\Seeders;

use App\Models\Habit;
use Illuminate\Database\Seeder;

class HabitSeeder extends Seeder
{
    public function run(): void
    {
        // Data habit yang diinginkan (PERMANEN)
        $habits = [
            ['name' => 'Belajar Bahasa Asing', 'icon' => '🌍', 'is_permanent' => true],
            ['name' => 'Gym', 'icon' => '💪', 'is_permanent' => true],
            ['name' => 'Skincare', 'icon' => '🧴', 'is_permanent' => true],
            ['name' => 'go to ITB', 'icon' => '🫀', 'is_permanent' => true],
            ['name' => 'Explore', 'icon' => '🔍', 'is_permanent' => true],
            ['name' => 'Belajar Coding </>', 'icon' => '👨🏻‍💻', 'is_permanent' => true],
        ];

        // Ambil semua nama habit permanen
        $permanentNames = array_column($habits, 'name');
        
        // Hapus habit yang tidak ada di daftar permanen dan bukan temporary
        Habit::whereNotIn('name', $permanentNames)->where('is_permanent', true)->delete();
        
        // Create atau update habit permanen
        foreach ($habits as $habit) {
            Habit::updateOrCreate(
                ['name' => $habit['name']],
                ['icon' => $habit['icon'], 'is_permanent' => $habit['is_permanent']]
            );
        }
    }
}