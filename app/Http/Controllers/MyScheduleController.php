<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Scheduler;
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

        // Obtiene las citas del día para el usuario autenticado
        $dayScheduler = Scheduler::where('client_user_id', auth()->id())
            ->whereDate('from', $date->format('Y-m-d'))
            ->get();

        // Devuelve la vista 'my-schedule.index' con los datos de la fecha y las citas del día
        return view('my-schedule.index')
            ->with([
                'date' => $date,
                'dayScheduler' => $dayScheduler,
            ]);
    }

    public function create()
    {
        return view('my-schedule.create');
    }
}
