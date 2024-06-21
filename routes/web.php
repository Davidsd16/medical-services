<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyScheduleController;
use App\Http\Controllers\StaffSchedulerController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersServicesController;
use App\Http\Controllers\OpeningHoursController;
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
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas que requieren autenticación, verificación de email y rol de cliente
Route::middleware(['auth', 'verified', 'role:client'])->prefix('my-schedule')->group(function () {
    Route::get('/', [MyScheduleController::class, 'index'])->name('my-schedule.index'); 
    Route::get('/create', [MyScheduleController::class, 'create'])->name('my-schedule.create');
    Route::post('/store', [MyScheduleController::class, 'store'])->name('my-schedule.store'); // Método POST para almacenar
    Route::delete('/{schedule}', [MyScheduleController::class, 'destroy'])->name('my-schedule.destroy');
    Route::get('/{schedule}/edit', [MyScheduleController::class, 'edit'])->name('my-schedule.edit');
    Route::put('/{schedule}', [MyScheduleController::class, 'update'])->name('my-schedule.update');
});

// Grupo de rutas que requieren autenticación y rol de staff
Route::middleware(['auth', 'role:staff'])->group(function(){
    Route::get('/staff-schedule', [StaffSchedulerController::class, 'index'])->name('staff-scheduler.index');
    Route::delete('/staff-schedule/{scheduler}', [StaffSchedulerController::class, 'destroy'])->name('staff-scheduler.destroy');
    Route::get('/staff-schedule/{scheduler}/edit', [StaffSchedulerController::class, 'edit'])->name('staff-scheduler.edit');
    Route::put('/staff-schedule/{scheduler}', [StaffSchedulerController::class, 'update'])->name('staff-scheduler.update');
});

// Grupo de rutas que requieren autenticación y rol de admin
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::get('users/{user}/services/edit', [UsersServicesController::class, 'edit'])->name('users-services.edit');
    Route::put('/users/{user}/services', [UsersServicesController::class, 'update'])->name('users-services.update');
    Route::get('/opening-hours/edit', [OpeningHoursController::class, 'edit'])->name('opening-hours.edit');
    Route::post('/opening-hours/update', [OpeningHoursController::class, 'update'])->name('opening-hours.update');
});

// Agrupa las rutas de perfil que requieren autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Requiere las rutas de autenticación generadas por Laravel
require __DIR__ . '/auth.php';
