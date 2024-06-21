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
    return view('welcome');  // Devuelve la vista 'welcome' al acceder a la raíz del sitio
});

// Ruta para la página "about"
Route::view('/about', 'about');  // Devuelve la vista 'about' cuando se accede a '/about'

// Ruta para mostrar el panel de control, requiere autenticación, verificación de email y rol de cliente
Route::get('/dashboard', function () {
    return view('dashboard');  // Devuelve la vista 'dashboard' para usuarios autenticados y verificados con rol de cliente
})->middleware(['auth', 'verified'])->name('dashboard');

// Grupo de rutas que requieren autenticación, verificación de email y rol de cliente
Route::middleware(['auth', 'verified', 'role:client'])->prefix('my-schedule')->group(function () {
    Route::get('/', [MyScheduleController::class, 'index'])->name('my-schedule.index');  // Muestra la agenda del usuario autenticado
    Route::get('/create', [MyScheduleController::class, 'create'])->name('my-schedule.create');  // Muestra el formulario para crear una nueva cita
    Route::post('/store', [MyScheduleController::class, 'store'])->name('my-schedule.store'); // Almacena una nueva cita en la base de datos
    Route::delete('/{schedule}', [MyScheduleController::class, 'destroy'])->name('my-schedule.destroy'); // Elimina una cita existente
    Route::get('/{schedule}/edit', [MyScheduleController::class, 'edit'])->name('my-schedule.edit'); // Muestra el formulario para editar una cita
    Route::put('/{schedule}', [MyScheduleController::class, 'update'])->name('my-schedule.update'); // Actualiza una cita existente
});

// Grupo de rutas que requieren autenticación y rol de staff
Route::middleware(['auth', 'role:staff'])->group(function(){
    Route::get('/staff-schedule', [StaffSchedulerController::class, 'index'])->name('staff-scheduler.index'); // Muestra la agenda del personal
    Route::delete('/staff-schedule/{scheduler}', [StaffSchedulerController::class, 'destroy'])->name('staff-scheduler.destroy'); // Elimina una cita del personal
    Route::get('/staff-schedule/{scheduler}/edit', [StaffSchedulerController::class, 'edit'])->name('staff-scheduler.edit'); // Muestra el formulario para editar una cita del personal
    Route::put('/staff-schedule/{scheduler}', [StaffSchedulerController::class, 'update'])->name('staff-scheduler.update'); // Actualiza una cita del personal
});

// Grupo de rutas que requieren autenticación y rol de admin
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/users', [UsersController::class, 'index'])->name('users.index'); // Muestra la lista de usuarios
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create'); // Muestra el formulario para crear un nuevo usuario
    Route::post('/users/store', [UsersController::class, 'store'])->name('users.store'); // Almacena un nuevo usuario en la base de datos
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit'); // Muestra el formulario para editar un usuario existente
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update'); // Actualiza los datos de un usuario
    Route::get('users/{user}/services/edit', [UsersServicesController::class, 'edit'])->name('users-services.edit'); // Muestra el formulario para editar los servicios de un usuario
    Route::put('/users/{user}/services', [UsersServicesController::class, 'update'])->name('users-services.update'); // Actualiza los servicios de un usuario
    Route::get('/opening-hours/edit', [OpeningHoursController::class, 'edit'])->name('opening-hours.edit'); // Muestra el formulario para editar el horario de apertura
    Route::post('/opening-hours/update', [OpeningHoursController::class, 'update'])->name('opening-hours.update'); // Actualiza el horario de apertura
});

// Agrupa las rutas de perfil que requieren autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Muestra el formulario de edición del perfil del usuario autenticado
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Actualiza el perfil del usuario autenticado
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Elimina el perfil del usuario autenticado
});

// Requiere las rutas de autenticación generadas por Laravel
require __DIR__ . '/auth.php';
