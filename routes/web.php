<?php

// Importa el controlador ProfileController desde el espacio de nombres App\Http\Controllers
use App\Http\Controllers\ProfileController;
// Importa la fachada Route de Laravel para definir las rutas de la aplicación
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DateController;
use App\Http\Controllers\MyScheduleController;



// Define una ruta GET para la URL raíz ('/')
// Esta ruta devuelve la vista 'welcome'
Route::get('/', function () {
    return view('welcome');
});

// Define una ruta de vista para la URL '/about'
// Esta ruta simplemente devuelve la vista 'about'
Route::view('/about', 'about');

// Define una ruta GET para la URL '/dashboard'
// Esta ruta devuelve la vista 'dashboard'
// Aplica los middleware 'auth' y 'verified' para asegurar que el usuario esté autenticado y verificado
// Además, nombra esta ruta como 'dashboard'
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Define una ruta GET para la URL '/my-schedule'
// Esta ruta devuelve la vista 'my-schedule.index'
// Aplica los middleware 'auth' y 'verified' para asegurar que el usuario esté autenticado y verificado
// Además, nombra esta ruta como 'my-schedule'
Route::get('/my-schedule', function () {
    return view('my-schedule.index');
})->middleware(['auth', 'verified'])->name('my-schedule');


Route::get('/my-schedule', [MyScheduleController::class, 'index'])->name('my-schedule.index');


// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Requiere las rutas de autenticación generadas por Laravel
require __DIR__.'/auth.php';
