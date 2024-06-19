<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Importa la librería Carbon para manejar fechas
use App\Http\Controllers\Controller; // Importa el controlador base
use App\Models\Scheduler; // Importa el modelo Scheduler
use Illuminate\Http\Request; // Importa la clase Request de Laravel

class StaffSchedulerController extends Controller
{
    // Método para manejar la solicitud de visualización del horario del personal
    public function index(Request $request) {
        // Parsear la fecha de la consulta de solicitud
        $date = Carbon::parse($request->query('date'));

        // Obtener el horario del día para el usuario autenticado
        $dayScheduler = Scheduler::where('staff_user_id', auth()->id()) // Filtra por el ID del usuario autenticado
            ->whereDate('from', $date->format('Y-m-d')) // Filtra por la fecha especificada
            ->orderBy('from', 'ASC') // Ordena los resultados por la hora de inicio de forma ascendente
            ->get();

        // Devuelve la vista 'staff-scheduler.index' con los datos necesarios
        return view('staff-scheduler.index')->with([
            'date' => $date, // Pasa la fecha a la vista
            'dayScheduler' => $dayScheduler, // Pasa el horario del día a la vista
        ]);
    }

    public function destroy()
    {
        var_dump('llego');
    }
}
