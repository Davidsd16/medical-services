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
        // Obtén solo los datos de apertura y cierre excluyendo otros datos no deseados
        $data = $request->input('hours');

        // Verifica si los datos están presentes y son un array
        if (is_null($data) || !is_array($data)) {
            return back()->withErrors(['message' => 'No se recibieron los datos esperados']);
        }

        // Itera sobre los datos para actualizar cada día
        foreach ($data as $day => $hours) {
            if (isset($hours['open']) && isset($hours['close'])) {
                OpeningHour::where('day', $day)
                    ->update([
                        'open' => $hours['open'],
                        'close' => $hours['close']
                    ]);
            }
        }
    
        $request->sucsses()->flash('success', 'Los horarios se actualizaron correctamente.');

        return back();
    }
    
    
}
