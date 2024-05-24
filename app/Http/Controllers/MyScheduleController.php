<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MyScheduleController extends Controller
{
    /**
     * Muestra la agenda para una fecha específica.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Analiza el parámetro de consulta 'date' a una instancia de Carbon
        $date = Carbon::parse($request->query('date'));

        // Devuelve la vista 'my-schedule.index' con los datos de la fecha
        return view('my-schedule.index')
            ->with([
                'date' => $date,
            ]);
    }
}
