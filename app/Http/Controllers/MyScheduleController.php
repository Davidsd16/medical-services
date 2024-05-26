<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Scheduler;
use App\Models\Service;
use App\Models\User;
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
    public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'from.date' => 'required|date',
            'from.time' => 'required',
            'service_id' => 'required|exists:services,id',
            'staff_user_id' => 'required|exists:users,id',
        ]);

        // Obtiene el servicio seleccionado
        $service = Service::find(request('service_id'));

        // Combina la fecha y la hora de inicio en una instancia de Carbon
        $from = Carbon::parse($request->input('from.date') . ' ' . $request->input('from.time'));

        // Calcula la hora de finalización añadiendo la duración del servicio
        $to = $from->addMinutes($service->duration);

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
}
