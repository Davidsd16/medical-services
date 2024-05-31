<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Service;
use App\Models\Scheduler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MyScheduleRequest;
use App\Business\DeletePermissionChecker;
use Illuminate\Console\Scheduling\Schedule;

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
            ->orderBy('from', 'ASC')
            ->get();

        // Devuelve la vista 'my-schedule.index' con los datos de la fecha y las citas del día
        return view('my-schedule.index')->with([
            'date' => $date,
            'dayScheduler' => $dayScheduler,
        ]);
    }

    /**
     * Muestra el formulario para crear una nueva cita.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Obtiene todos los servicios disponibles
        $services = Service::all();
    
        // Obtiene todos los usuarios con el rol 'staff'
        $staffUsers = User::role('staff')->get();
        
        // Devuelve la vista 'my-schedule.create' con los servicios disponibles y los usuarios del staff
        return view('my-schedule.create')->with([
            'services' => $services,
            'staffUsers' => $staffUsers, 
        ]);
    }

    /**
     * Almacena una nueva cita.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MyScheduleRequest $request)
    {
        // Obtiene el servicio seleccionado
        $service = Service::find(request('service_id'));

        // Combina la fecha y la hora de inicio en una instancia de Carbon
        $from = Carbon::parse($request->input('from.date') . ' ' . $request->input('from.time'));

        // Calcula la hora de finalización añadiendo la duración del servicio
        $to = Carbon::parse($from)->addMinutes($service->duration);

        // Busca el usuario del personal basado en el 'staff_user_id' proporcionado en la solicitud
        $staffUser = User::find($request->input('staff_user_id'));

        // Llama a la función que verifica las reglas de reserva para comprobar la disponibilidad del personal, del cliente y la prestación del servicio
        $request->checkReservationRules($staffUser, auth()->user(), $from, $to, $service);
        
        // Crea una nueva cita en la base de datos
        Scheduler::create([
            'from' => $from,
            'to' => $to,
            'status' => 'pending',
            'staff_user_id' => request('staff_user_id'),
            'client_user_id' => auth()->id(),
            'service_id' => $service->id,
        ]);

        // Redirige a la vista del calendario con un mensaje de éxito
        return redirect()->route('my-schedule.index', [
            'date' => $from->format('Y-m-d')
                ])->with('success', 'Cita creada con éxito.');
    }

    /**
     * Elimina una cita existente.
     *
     * @param \App\Models\Scheduler $scheduler
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Scheduler $scheduler)
    {
        // Verifica los permisos para eliminar la cita
        $checker = new DeletePermissionChecker($scheduler, auth()->user());

        // Si no tiene permisos, redirige de vuelta con un mensaje de error
        if (!$checker->check()) {
            return back()->withErrors('No tienes permiso para eliminar esta cita o la cita ya ha pasado.');
        }

        // Elimina la cita
        $scheduler->delete();

        // Redirige a la vista del calendario con un mensaje de éxito
        return redirect()->route('my-schedule.index')->with('success', 'Cita eliminada con éxito.');
    }

    public function edit(Scheduler $schedule)
    {
        $services = Service::all();
    
        $staffUsers = User::role('staff')->get();

        return view('my-schedule.edit')->with([
            'schedule' => $schedule,
            'services' => $services,
            'staffUsers' => $staffUsers, 
        ]);
    }

    public function update()
    {
        
    }

}
