<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Scheduler;
use App\Http\Requests\StaffScheduleRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class StaffSchedulerController extends Controller
{
    /**
     * Muestra las citas del personal para una fecha específica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Parsea la fecha desde el query string del request
        $date = Carbon::parse($request->query('date'));

        // Obtiene las citas del usuario actual para la fecha especificada
        $dayScheduler = Scheduler::where('staff_user_id', auth()->id())
            ->whereDate('from', $date->format('Y-m-d'))
            ->orderBy('from', 'ASC')
            ->get();

        // Retorna la vista 'staff-scheduler.index' con la fecha y las citas obtenidas
        return view('staff-scheduler.index')->with([
            'date' => $date,
            'dayScheduler' => $dayScheduler,
        ]);
    }

    /**
     * Muestra el formulario de edición de una cita específica.
     *
     * @param  \App\Models\Scheduler  $scheduler
     * @return \Illuminate\View\View
     */
    public function edit(Scheduler $scheduler)
    {
        // Retorna la vista 'staff-scheduler.edit' con los datos de la cita a editar
        return view('staff-scheduler.edit', compact('scheduler'));
    }

    /**
     * Actualiza una cita específica del personal.
     *
     * @param  \App\Models\Scheduler  $scheduler
     * @param  \App\Http\Requests\StaffScheduleRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Scheduler $scheduler, StaffScheduleRequest $request)
    {
        // Obtiene el usuario del personal autenticado
        $staffUser = auth()->user();
        
        // Encuentra al usuario cliente asociado a la cita
        $clientUser = User::find($scheduler->client_user_id);

        // Si el usuario cliente no existe, retorna con un mensaje de error
        if (!$clientUser) {
            return back()->withErrors('Usuario cliente no encontrado')->withInput();
        }

        // Obtiene el servicio asociado a la cita
        $service = $scheduler->service;

        // Parsea la fecha y hora desde el input del formulario
        $from = Carbon::parse($request->input('from.date') . ' ' . $request->input('from.time'));
        
        // Calcula la fecha de fin sumando la duración del servicio
        $to = Carbon::parse($from)->addMinutes($service->duration);

        // Verifica las reglas de reprogramación con el método del request
        $request->checkRescheduleRules($scheduler, $staffUser, $clientUser, $from, $to, $service);

        // Actualiza la cita con los nuevos datos
        $scheduler->update([
            'from' => $from,
            'to' => $to,
        ]);

        // Redirige de vuelta al índice de citas del personal con un mensaje de éxito
        return redirect()->route('staff-scheduler.index', [
            'date' => $from->format('Y-m-d')
        ])->with('success', 'Cita actualizada con éxito.');
    }

    /**
     * Elimina una cita específica del personal.
     *
     * @param  \App\Models\Scheduler  $scheduler
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Scheduler $scheduler)
    {
        // Carga los usuarios cliente y del personal asociados a la cita
        $scheduler->load(['clientUser', 'staffUser']);
        
        // Obtiene al usuario autenticado
        $user = auth()->user();
        
        // Si la cita no existe, redirige con un mensaje de error
        if (!$scheduler) {
            return redirect()->route('my-schedule.index')->withErrors('Cita no encontrada.');
        }

        // Verifica si el usuario tiene permisos para eliminar la cita
        if ($scheduler->client_user_id != $user->id && $scheduler->staff_user_id != $user->id) {
            return back()->withErrors('No tienes permiso para cancelar esta cita.');
        }

        // Elimina la cita
        $scheduler->delete();

        // Redirige de vuelta al índice de citas del personal con un mensaje de éxito
        return redirect()->route('my-schedule.index')->with('success', 'Cita eliminada con éxito.');
    }
}
