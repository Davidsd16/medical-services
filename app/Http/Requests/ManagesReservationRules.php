<?php

namespace App\Http\Requests;

use App\Business\OpeningHourChecker;
use App\Business\StaffServiceChecker;
use App\Business\StaffAvailabilityChecker;
use App\Business\ClientAvailabilityChecker;

trait ManagesReservationRules
{
    public function checkReservationRules($staffUser, $clientUser, $from, $to, $service)
    {
        // Verifica la disponibilidad del personal en el horario especificado
        $staffChecker = new StaffAvailabilityChecker($staffUser, $from, $to, null, $service);
        if (!$staffChecker->check()) {
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

    public function checkRescheduleRules($scheduler, $staffUser, $clientUser, $from, $to, $service)
    {
        // Verifica la disponibilidad del personal en el horario especificado, ignorando la cita actual
        $staffChecker = new StaffAvailabilityChecker($staffUser, $from, $to, $scheduler, $service);
        $staffChecker->ignore($scheduler);
        if (!$staffChecker->check()) {
            return back()->withErrors('Este horario no está disponible')->withInput();
        }
    
        // Verifica la disponibilidad del cliente en el horario especificado, ignorando la cita actual
        $clientChecker = new ClientAvailabilityChecker($clientUser, $from, $to);
        $clientChecker->ignore($scheduler);
        if (!$clientChecker->check()) {
            return back()->withErrors('Ya tienes una reserva confirmada en este horario')->withInput();
        }
    
        // Verifica que el personal preste el servicio solicitado, ignorando la cita actual
        if (!(new StaffServiceChecker($staffUser, $service))->check()) {
            return back()->withErrors("{$staffUser->name} no presta el servicio de {$service->name}.")->withInput();
        }

        // Verifica que la reserva esté dentro del horario de atención
        if (!(new OpeningHourChecker($from, $to))->check()) {
            return back()->withErrors('La reserva está fuera del horario de atención')->withInput();
        }
    }
}
