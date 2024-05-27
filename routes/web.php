<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyScheduleController;
use Illuminate\Support\Facades\Route;

// Ruta para la página de inicio
Route::get('/', function () {
    return view('welcome');
});

// Ruta para la página "about"
Route::view('/about', 'about');

// Grupo de rutas que requieren autenticación y verificación de email
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Ruta para mostrar el panel de control
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard'); // Nombre de la ruta: 'dashboard'

    // Ruta para mostrar la agenda del usuario autenticado
    Route::get('/my-schedule', [MyScheduleController::class, 'index'])
        ->name('my-schedule.index'); // Nombre de la ruta: 'my-schedule.index'

    // Ruta para mostrar el formulario de creación de una nueva cita
    Route::get('/my-schedule/create', [MyScheduleController::class, 'create'])
        ->name('my-schedule.create'); // Nombre de la ruta: 'my-schedule.create'

    // Ruta para almacenar una nueva cita en la base de datos
    Route::get('/my-schedule/store', [MyScheduleController::class, 'store'])
        ->name('my-schedule.store'); // Nombre de la ruta: 'my-schedule.store'

    // Ruta para eliminar una cita existente
    Route::delete('/my-schedule/{scheduler}', [MyScheduleController::class, 'destroy'])
        ->name('my-schedule.destroy'); // Nombre de la ruta: 'my-schedule.destroy'
});

// Agrupa las rutas de perfil que requieren autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Requiere las rutas de autenticación generadas por Laravel
require __DIR__.'/auth.php';
