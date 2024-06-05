<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyScheduleController;
use App\Http\Controllers\StaffSchedulerController;
use Illuminate\Support\Facades\Route;

// Ruta para la página de inicio
Route::get('/', function () {
    return view('welcome');
});

// Ruta para la página "about"
Route::view('/about', 'about');

// Ruta para mostrar el panel de control, requiere autenticación, verificación de email y role de cliente
Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard'); // Nombre de la ruta: 'dashboard'

// Grupo de rutas que requieren autenticación, verificación de email yrole de cliente
Route::middleware(['auth', 'verified', 'role:client'])
    ->prefix('my-schedule')
    ->group(function () {
        // Ruta para mostrar la agenda del usuario autenticado
        Route::get('/', [MyScheduleController::class, 'index'])
            ->name('my-schedule.index'); // Nombre de la ruta: 'my-schedule.index'

        // Ruta para mostrar el formulario de creación de una nueva cita
        Route::get('/create', [MyScheduleController::class, 'create'])
            ->name('my-schedule.create'); // Nombre de la ruta: 'my-schedule.create'

        // Ruta para almacenar una nueva cita en la base de datos
        Route::post('/store', [MyScheduleController::class, 'store'])
            ->name('my-schedule.store'); // Nombre de la ruta: 'my-schedule.store'

        // Ruta para eliminar una cita existente
        Route::delete('/{schedule}', [MyScheduleController::class, 'destroy'])
            ->name('my-schedule.destroy'); // Nombre de la ruta: 'my-schedule.destroy'

        // Muestra el formulario de edición de una cita específica
        Route::get('/{schedule}/edit', [MyScheduleController::class, 'edit'])
            ->name('my-schedule.edit');

        // Actualiza una cita específica
        Route::put('/{schedule}', [MyScheduleController::class, 'update'])
            ->name('my-schedule.update');
    });

    Route::get('/staff-schedule', [StaffSchedulerController::class, 'index'])
            ->name('staff-scheduler.index');     

// Agrupa las rutas de perfil que requieren autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Requiere las rutas de autenticación generadas por Laravel
require __DIR__.'/auth.php';

