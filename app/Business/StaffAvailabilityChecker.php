<?php

namespace App\Business;

use App\Models\Scheduler;

class StaffAvailabilityChecker
{
    protected $staffUser;
    protected $from;
    protected $to;
    protected $scheduler;
    protected $service;

    public function __construct($staffUser, $from, $to, $scheduler = null, $service = null)
    {
        $this->staffUser = $staffUser;
        $this->from = $from;
        $this->to = $to;
        $this->scheduler = $scheduler;
        $this->service = $service;
    }

    public function ignore($scheduler)
    {
        $this->scheduler = $scheduler;
        return $this;
    }

    public function check()
    {
        // Verifica si existen conflictos en la agenda del personal
        $staffConflict = Scheduler::where('staff_user_id', $this->staffUser->id)
            ->when($this->scheduler, function($query) {
                $query->where('id', '<>', $this->scheduler->id);
            })
            ->where('from', '<', $this->to)
            ->where('to', '>', $this->from)
            ->exists();

        // Verifica si el miembro del personal está asignado a otro servicio en el mismo rango de tiempo
        $staffServiceConflict = Scheduler::where('staff_user_id', $this->staffUser->id)
            ->where('service_id', '<>', $this->service->id)
            ->when($this->scheduler, function($query) {
                $query->where('id', '<>', $this->scheduler->id);
            })
            ->where('from', '<', $this->to)
            ->where('to', '>', $this->from)
            ->exists();

        return !$staffConflict && !$staffServiceConflict;
    }
}

?>
