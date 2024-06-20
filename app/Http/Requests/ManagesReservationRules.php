<?php

namespace App\Http\Requests;

use App\Business\OpeningHourChecker;
use App\Business\StaffServiceChecker;
use App\Business\StaffAvailabilityChecker;
use App\Business\ClientAvailabilityChecker;

trait ManagesReservationRules
{
    /**
     * Verifica las reglas de reserva para una nueva cita.
     *
     * @param $staffUser El usuario del personal que va a atender.
     * @param $clientUser El usuario cliente que hace la reserva.
     * @param $from Fecha y hora de inicio de la reserva.
     * @param $to Fecha y hora de fin de la reserva.
     * @param $service El servicio que se va a realizar.
     * @return \Illuminate\Http\RedirectResponse|null Redirige con errores si alguna regla no se cumple.
     */
    public function checkReservationRules($staffUser, $clientUser, $from, $to, $service)
    {
        // Verifica la disponibilidad del personal en el horario especificado
        if (!(new StaffAvailabilityChecker($staffUser, $from, $to))->check()) {
            return back()->withErrors('Este horario no está disponible')->withInput();
        }
    
        // Verifica la disponibilidad del cliente en el horario especificado
        if (!(new ClientAvailabilityChecker($clientUser, $from, $to))->check()) {
            return back()->withErrors('Ya tienes una reserva confirmada en este horario')->withInput();
        }
    
        // Verifica que el personal preste el servicio solicitado
        if (!(new StaffServiceChecker($staffUser, $service))->check()) {
            return back()->withErrors("{$staffUser->name} no presta el servicio de {$service->name}.")->withInput();
        }

        // Verifica que la reserva esté dentro del horario de atención
        if (!(new OpeningHourChecker($from, $to))->check()) {
            return back()->withErrors('La reserva está fuera del horario de atención')->withInput();
        }
    }

    /**
     * Verifica las reglas para reprogramar una cita existente.
     *
     * @param $scheduler La cita que se está reprogramando.
     * @param $staffUser El usuario del personal que va a atender.
     * @param $clientUser El usuario cliente que hace la reserva.
     * @param $from Fecha y hora de inicio de la reserva.
     * @param $to Fecha y hora de fin de la reserva.
     * @param $service El servicio que se va a realizar.
     * @return \Illuminate\Http\RedirectResponse|null Redirige con errores si alguna regla no se cumple.
     */
    public function checkRescheduleRules($scheduler, $staffUser, $clientUser, $from, $to, $service)
    {
        // Verifica la disponibilidad del personal en el horario especificado, ignorando la cita actual
        if (!(new StaffAvailabilityChecker($staffUser, $from, $to, $scheduler))->ignore($scheduler)->check()) {
            return back()->withErrors('Este horario no está disponible')->withInput();
        }
    
        // Verifica la disponibilidad del cliente en el horario especificado, ignorando la cita actual
        if (!(new ClientAvailabilityChecker($clientUser, $from, $to))->ignore($scheduler)->check()) {
            return back()->withErrors('Ya tienes una reserva confirmada en este horario')->withInput();
        }
    
        // Verifica que el personal preste el servicio solicitado, ignorando la cita actual
        if (!(new StaffServiceChecker($staffUser, $service))->ignore($scheduler)->check()) {
            return back()->withErrors("{$staffUser->name} no presta el servicio de {$service->name}.")->withInput();
        }

        // Verifica que la reserva esté dentro del horario de atención
        if (!(new OpeningHourChecker($from, $to))->check()) {
            return back()->withErrors('La reserva está fuera del horario de atención')->withInput();
        }
    }
}
