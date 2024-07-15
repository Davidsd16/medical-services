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
     * @param \App\Http\Requests\MyScheduleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MyScheduleRequest $request)
    {
        // Valida los datos del formulario
        $validatedData = $request->validate([
            'from.date' => 'required|date',
            'from.time' => 'required',
            'service_id' => 'required|exists:services,id',
            'staff_user_id' => 'required|exists:users,id',
        ]);
        // dd($validatedData);  // Verifica los datos validados
    
        // Obtiene el servicio seleccionado
        $service = Service::find($request->input('service_id'));
    
        // Combina la fecha y la hora de inicio en una instancia de Carbon
        $from = Carbon::parse($request->input('from.date') . ' ' . $request->input('from.time'));
    
        // Calcula la hora de finalización añadiendo la duración del servicio
        $to = Carbon::parse($from)->addMinutes($service->duration);
    
        // Busca el usuario del personal basado en el 'staff_user_id' proporcionado en la solicitud
        $staffUser = User::find($request->input('staff_user_id'));
    
        // Llama a la función que verifica las reglas de reserva para comprobar la disponibilidad del personal, del cliente y la prestación del servicio
        $request->checkReservationRules($staffUser, auth()->user(), $from, $to, $service);
        // dd('Passed checkReservationRules');
    
        // Crea una nueva cita en la base de datos
        try {
            $scheduler = Scheduler::create([
                'from' => $from,
                'to' => $to,
                'status' => 'pending',
                'staff_user_id' => $staffUser->id,
                'client_user_id' => auth()->id(),
                'service_id' => $service->id,
            ]);
        } catch (\Exception $e) {
            dd('Error:', $e->getMessage());
        }
    
        // Redirige a la vista del calendario con un mensaje de éxito
        return redirect()->route('my-schedule.index', [
            'date' => $from->format('Y-m-d')
        ])->with('success', 'Cita creada con éxito.');
    }

    /**
     * Elimina una cita existente.
     *
     * @param \App\Models\Scheduler $schedule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Scheduler $schedule)
    {
        // Verifica que el Scheduler se ha cargado correctamente
        if (!$schedule) {
            return redirect()->route('my-schedule.index')->withErrors('Cita no encontrada.');
        }

        // Verifica los permisos para eliminar la cita
        $checker = new DeletePermissionChecker($schedule, auth()->user());

        // Si no tiene permisos, redirige de vuelta con un mensaje de error
        if (!$checker->check()) {
            return back()->withErrors('No tienes permiso para eliminar esta cita o la cita ya ha pasado.');
        }

        // Elimina la cita
        $schedule->delete();

        // Redirige a la vista del calendario con un mensaje de éxito
        return redirect()->route('my-schedule.index')->with('success', 'Cita eliminada con éxito.');
    }

    public function edit(Scheduler $schedule)
    {
        // Obtiene todos los servicios disponibles
        $services = Service::all();
    
        // Obtiene todos los usuarios con el rol 'staff'
        $staffUsers = User::role('staff')->get();
    
        // Retorna la vista 'my-schedule.edit' pasando los datos necesarios
        return view('my-schedule.edit')->with([
            'schedule' => $schedule,  // Pasa la cita a editar
            'services' => $services,  // Pasa la lista de servicios
            'staffUsers' => $staffUsers,  // Pasa la lista de usuarios del personal
        ]);
    }
    
    public function update(Scheduler $schedule, MyScheduleRequest $request)
    {
        // Busca el servicio seleccionado basado en el ID proporcionado en la solicitud
        $service = Service::find(request('service_id'));
    
        // Combina la fecha y la hora proporcionadas en la solicitud para crear un objeto Carbon de la fecha y hora de inicio
        $from = Carbon::parse($request->input('from.date') . ' ' . $request->input('from.time'));
    
        // Calcula la fecha y hora de finalización sumando la duración del servicio a la fecha y hora de inicio
        $to = Carbon::parse($from)->addMinutes($service->duration);
    
        // Busca el usuario del personal seleccionado basado en el ID proporcionado en la solicitud
        $staffUser = User::find($request->input('staff_user_id'));
    
        // Verifica las reglas de reservación con el usuario del personal, el usuario autenticado, la fecha y hora de inicio y finalización, y el servicio
        $request->checkRescheduleRules($schedule, $staffUser, auth()->user(), $from, $to, $service);
    
        // Actualiza la cita con los nuevos valores
        $schedule->update([
            'from' => $from,  // Fecha y hora de inicio
            'to' => $to,  // Fecha y hora de finalización
            'staff_user_id' => request('staff_user_id'),  // ID del usuario del personal que atenderá
            'service_id' => $service->id,  // ID del servicio seleccionado
        ]);
    
        // Redirige al índice de citas con un mensaje de éxito
        return redirect()->route('my-schedule.index', [
            'date' => $from->format('Y-m-d')  // Fecha de la cita para filtrar el índice
        ])->with('success', 'Cita creada con éxito.');
    }
}
