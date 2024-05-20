<?php

use App\Http\Controllers\MyScheduleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

// Ruta para la página "about"
Route::view('/about', 'about');

Route::middleware('auth')->group(function () {
    Route::get('/my-schedule', function () {
        return view('my-schedule.index');
    })->name('my-schedule');

    Route::get('/dashboard', [MyScheduleController::class, 'index'])
        ->name('dashboard');
});




// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Requiere las rutas de autenticación generadas por Laravel
require __DIR__.'/auth.php';
