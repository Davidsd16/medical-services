<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/about', 'about');

// Agrupa las rutas que requieren autenticación y verificación
Route::middleware(['auth', 'verified'])->group(function () {
    // Define la ruta para el dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Define las rutas para el calendario
    Route::get('/my-schedule', [MyScheduleController::class, 'index'])->name('my-schedule.index');
    
    Route::get('/my-schedule/create', [MyScheduleController::class, 'create'])->name('my-schedule.create');

    Route::get('/my-schedule/store', [MyScheduleController::class, 'store'])->name('my-schedule.store'); // Cambiado a 'store'

});

// Agrupa las rutas de perfil que requieren autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Requiere las rutas de autenticación generadas por Laravel
require __DIR__.'/auth.php';
