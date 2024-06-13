<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class UsersServicesController extends Controller
{
    // Método para mostrar el formulario de edición de servicios para un usuario específico
    public function edit(User $user)
    {
        // Se obtienen todos los servicios disponibles desde el modelo Service
        $services = Service::all();

        // Se retorna la vista 'users-services.edit' junto con los datos necesarios
        return view('users-services.edit')->with([
            'user' => $user,
            'services' => $services,
        ]);
    }
}
