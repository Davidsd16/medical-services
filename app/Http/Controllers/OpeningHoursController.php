<?php

namespace App\Http\Controllers;

 // Importa el modelo OpeningHour
use App\Models\OpeningHour;
use Illuminate\Http\Request;
// Importa el formulario de solicitud OpeningHourRequest
use App\Http\Requests\OpeningHourRequest; 

class OpeningHoursController extends Controller
{
    // Método para mostrar el formulario de edición de horarios de apertura
    public function edit()
    {
        // Obtiene todos los registros de horarios de apertura desde el modelo OpeningHour
        $openingHours = OpeningHour::all();

        // Retorna la vista 'opening-hours.edit' junto con los horarios de apertura obtenidos
        return view('opening-hours.edit')->with([
            'openingHours' => $openingHours,
        ]);
    }

    // Método para actualizar los horarios de apertura
    public function update(OpeningHourRequest $request)
    {
        // Elimina los datos de la solicitud para depuración
        // dd(request()->all());

    }
}
