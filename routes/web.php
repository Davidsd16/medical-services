<?php

use App\Http\Controllers\ProfileController;
// Importa la fachada Route de Laravel para definir las rutas de la aplicación
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MyScheduleController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/about', 'about');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/my-schedule', function () {
        return view('my-schedule.index');
    })->name('my-schedule');

    Route::get('/my-schedule', [MyScheduleController::class, 'index'])->name('my-schedule.index');
});


// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Requiere las rutas de autenticación generadas por Laravel
require __DIR__.'/auth.php';
