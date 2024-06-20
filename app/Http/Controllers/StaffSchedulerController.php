<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StaffScheduleRequest;
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

    public function edit(Scheduler $scheduler)
    {
        return view('staff-scheduler.edit', compact('scheduler'));
    }

    public function update(Scheduler $scheduler, StaffScheduleRequest $request)
{
    $staffUser = auth()->user(); // Obtén el usuario del personal autenticado
    $clientUser = User::find($scheduler->client_user_id); // Obtén el usuario cliente relacionado con la cita

    // Asegúrate de que $clientUser no sea nulo
    if (!$clientUser) {
        return back()->withErrors('Usuario cliente no encontrado')->withInput();
    }

    $service = $scheduler->service;
    $from = Carbon::parse($request->input('from.date') . ' ' . $request->input('from.time'));
    $to = Carbon::parse($from)->addMinutes($service->duration);

    // Verifica las reglas de reprogramación
    $request->checkRescheduleRules($scheduler, $staffUser, $clientUser, $from, $to, $service);

    // Actualiza los campos 'from' y 'to' de la cita en la base de datos
    $scheduler->update([
        'from' => $from,  
        'to' => $to,  
    ]);

    // Redirige al índice del horario del personal con un mensaje de éxito
    return redirect()->route('staff-scheduler.index', [
        'date' => $from->format('Y-m-d')  
    ])->with('success', 'Cita actualizada con éxito.');
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
