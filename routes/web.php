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

// Grupo de rutas que requieren autenticación, verificación de email yrole de cliente
Route::middleware(['auth', 'verified', 'role:client'])
    ->prefix('my-schedule')
    ->group(function () {
        // Ruta para mostrar la agenda del usuario autenticado
        Route::get('/', [MyScheduleController::class, 'index'])->name('my-schedule.index'); 

        // Ruta para mostrar el formulario de creación de una nueva cita
        Route::get('/create', [MyScheduleController::class, 'create'])->name('my-schedule.create');

        // Ruta para almacenar una nueva cita en la base de datos
        Route::get('/store', [MyScheduleController::class, 'store'])->name('my-schedule.store');

        // Ruta para eliminar una cita existente
        Route::delete('/{schedule}', [MyScheduleController::class, 'destroy'])->name('my-schedule.destroy');

        // Muestra el formulario de edición de una cita específica
        Route::get('/{schedule}/edit', [MyScheduleController::class, 'edit'])->name('my-schedule.edit');

        // Actualiza una cita específica
        Route::put('/{schedule}', [MyScheduleController::class, 'update'])->name('my-schedule.update');

    });

// Define un grupo de rutas que aplican el middleware 'role:staff'
Route::middleware('role:staff')->group(function(){
    // Define una ruta GET para '/staff-schedule' que usa el método 'index' del controlador 'StaffSchedulerController'
    Route::get('/staff-schedule', [StaffSchedulerController::class, 'index'])->name('staff-scheduler.index');

    Route::delete('/staff-scheduler/{scheduler}', [StaffSchedulerController::class, 'destroy'])->name('staff-scheduler.destroy');

    Route::get('/staff-scheduler/{scheduler}/edit', [StaffSchedulerController::class, 'edit'])->name('staff-scheduler.edit');

    Route::put('/staff-scheduler/{scheduler}', [StaffSchedulerController::class, 'updeta'])->name('staff-scheduler.update');


});

// Define un grupo de rutas que aplican el middleware 'role:admin'
Route::middleware('role:admin')->group(function(){
    // Define una ruta GET para '/users' que usa el método 'index' del controlador 'UsersController'
    Route::get('/users',[UsersController::class, 'index'])
        ->name('users.index');

    // Define una ruta GET para editar los servicios de un usuario específico
    Route::get('users/{user}/services/edit', [UsersServicesController::class, 'edit'])
        ->name('users-services.edit');

    // Define una ruta PUT para actualizar los servicios de un usuario específico
    Route::put('/users/{user}/services', [UsersServicesController::class, 'update'])
        ->name('users-services.update');

    // Ruta para mostrar el formulario de creación de usuarios.
    Route::get('/users/create', [UsersController::class, 'create'])
        ->name('users.create');

    // Ruta para almacenar un nuevo usuario.
    Route::post('/users/store', [UsersController::class, 'store'])
        ->name('users.store');

    // Ruta para editar un usuario existente.
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])
        ->name('users.edit');
        
    // Ruta para actualizar los datos de un usuario.
    Route::put('/users/{user}', [UsersController::class, 'update'])
        ->name('users.update');

    Route::get('/opening-hours/edit', [OpeningHoursController::class, 'edit'])
        ->name('opening-hours.edit');

    Route::post('/opening-hours/update', [OpeningHoursController::class, 'update'])
        ->name('opening-hours.update');

});


// Agrupa las rutas de perfil que requieren autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Requiere las rutas de autenticación generadas por Laravel
require __DIR__ . '/auth.php';
