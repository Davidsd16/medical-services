<?php

namespace App\Http\Controllers;


use App\Models\OpeningHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
    public function update(Request $request)
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
    
        // Flash de mensaje de éxito en la sesión
        Session::put('success', 'Los horarios se actualizaron correctamente.');        return back();
    }
    
    
}
