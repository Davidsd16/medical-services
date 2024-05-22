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

        // Retornar la vista con la variable date
        return view('my-schedule.index', compact('date'));
    }
}
