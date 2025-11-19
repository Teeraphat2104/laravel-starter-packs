<?php

use App\Http\Controllers\DailyEntryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Daily Entries Routes
    Route::get('/daily-entries/calendar', [DailyEntryController::class, 'calendar'])->name('daily-entries.calendar');
    Route::get('/daily-entries/weekly-summary', [DailyEntryController::class, 'weeklySummary'])->name('daily-entries.weekly-summary');
    Route::get('/daily-entries/monthly-summary', [DailyEntryController::class, 'monthlySummary'])->name('daily-entries.monthly-summary');
    Route::get('/daily-entries/create', [DailyEntryController::class, 'create'])->name('daily-entries.create');
    Route::post('/daily-entries', [DailyEntryController::class, 'store'])->name('daily-entries.store');
    Route::get('/daily-entries/{id}/edit', [DailyEntryController::class, 'edit'])->name('daily-entries.edit');
    Route::put('/daily-entries/{id}', [DailyEntryController::class, 'update'])->name('daily-entries.update');
    Route::delete('/daily-entries/{id}', [DailyEntryController::class, 'destroy'])->name('daily-entries.destroy');
});

require __DIR__.'/auth.php';
