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

    public function update(User $user)
{
    // Valida que cada elemento en el array 'services_ids' exista en la tabla 'services' en la columna 'id'
    request()->validate([
        'services_ids.*' => 'exists:services,id'
    ]);

    // Sincroniza los servicios del usuario con los IDs proporcionados en la solicitud
    // Esto actualizará la tabla pivot 'service_user' con los servicios seleccionados
    $user->service()->sync(request('services_ids'));

    // Redirige al usuario a la ruta 'users.index' después de actualizar los servicios
    return redirect(route('users.index'));
}

}
