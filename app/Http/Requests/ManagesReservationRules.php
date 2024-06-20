<?php

namespace App\Http\Requests;

use App\Business\OpeningHourChecker;
use App\Business\StaffServiceChecker;
use App\Business\StaffAvailabilityChecker;
use App\Business\ClientAvailabilityChecker;

trait ManagesReservationRules
{
    public function checkReservationRules($staffUser, $clientUser, $from, $to, $service){

        if (!(new StaffAvailabilityChecker($staffUser, $from, $to))->check()) {
            return back()->withErrors('Este horario no está disponible')->withInput();
        }
    
        if (!(new ClientAvailabilityChecker($clientUser, $from, $to))->check()) {
            return back()->withErrors('Ya tienes una reserva confirmada en este horario')->withInput();
        }
    
        if (!(new StaffServiceChecker($staffUser, $service))->check()) {
            return back()->withErrors("{$staffUser->name} no presta el servicio de {$service->name}.")->withInput();
        }

        if (!(new OpeningHourChecker($from, $to))->check()) {
            return back()->withErrors('La reserva está fuera del horario de anteción')->withInput();
        }
    }

    public function checkRescheduleRules($scheduler, $staffUser, $clientUser, $from, $to, $service){
        
        if (!(new StaffAvailabilityChecker($staffUser, $from, $to, $scheduler))->ignore($scheduler)->check()) {
            return back()->withErrors('Este horario no está disponible')->withInput();
        }
    
        if (!(new ClientAvailabilityChecker($clientUser, $from, $to))->ignore($scheduler)->check()) {
            return back()->withErrors('Ya tienes una reserva confirmada en este horario')->withInput();
        }
    
        if (!(new StaffServiceChecker($staffUser, $service))->ignore($scheduler)->check()) {
            return back()->withErrors("{$staffUser->name} no presta el servicio de {$service->name}.")->withInput();
        }

        if (!(new OpeningHourChecker($from, $to))->check()) {
            return back()->withErrors('La reserva está fuera del horario de anteción')->withInput();
        }
    }
}