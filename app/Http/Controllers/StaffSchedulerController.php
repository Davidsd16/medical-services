<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Models\Scheduler; // Importa el modelo Scheduler
use App\Http\Controllers\Controller; // Importa el controlador base
use Illuminate\Http\Request; // Importa la clase Request de Laravel
use Carbon\Carbon; // Importa la librería Carbon para manejar fechas

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

    public function edit(Scheduler $schedule)
    {
        return view('staff-scheduler.edit')->with([
            'schedule' => $schedule,   
        ]);
    }

    public function destroy(Scheduler $schedule)
    {
        if (!$schedule) {
            return redirect()->route('my-schedule.index')->withErrors('Cita no encontrada.');
        }

        if (Gate::denies('delete', $schedule)) {
            return back()->withErrors('No es posible cancelar esta cita');
        }
        
        // Elimina la cita
        $schedule->delete();

        // Redirige a la vista del calendario con un mensaje de éxito
        return redirect()->route('my-schedule.index')->with('success', 'Cita eliminada con éxito.');
    }
}
