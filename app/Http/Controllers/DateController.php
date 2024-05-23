<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DateController extends Controller
{
    public function store(Request $request)
    {
        // Validar la entrada
        $request->validate([
            'date' => 'required|date'
        ]);

        // Obtener la fecha del formulario
        $date = $request->input('date');

        // Redirigir a la vista de la agenda con la fecha seleccionada
        return redirect()->route('my-schedule.index', ['date' => $date]);
    }

    public function index(Request $request)
    {
        // Obtener la fecha de la solicitud
        $date = $request->query('date', 'No date selected');

        // Retornar la vista con la variable date
        return view('my-schedule.index', compact('date'));
    }
}
