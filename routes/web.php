<?php

use App\Http\Controllers\HabitController;
use Illuminate\Support\Facades\Route;

// Halaman welcome sebagai halaman pertama
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route untuk habit tracker (dengan middleware auth opsional nanti)
Route::prefix('app')->group(function () {
    Route::get('/', [HabitController::class, 'index'])->name('habits.index');
    Route::post('/habits', [HabitController::class, 'store'])->name('habits.store');
    Route::delete('/habits/{habit}', [HabitController::class, 'destroy'])->name('habits.destroy');
    Route::post('/habits/{habit}/toggle', [HabitController::class, 'toggle'])->name('habits.toggle');
    Route::get('/history', [HabitController::class, 'history'])->name('habits.history');
});