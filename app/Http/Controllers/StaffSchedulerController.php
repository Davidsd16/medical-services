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
    public function index(Request $request)
    {
        $date = Carbon::parse($request->query('date'));

        $dayScheduler = Scheduler::where('staff_user_id', auth()->id())
            ->whereDate('from', $date->format('Y-m-d'))
            ->orderBy('from', 'ASC')
            ->get();

        return view('staff-scheduler.index')->with([
            'date' => $date,
            'dayScheduler' => $dayScheduler,
        ]);
    }

    public function edit(Scheduler $scheduler)
    {
        return view('staff-scheduler.edit', compact('scheduler'));
    }

    public function update(Scheduler $scheduler, StaffScheduleRequest $request)
    {
        $staffUser = auth()->user();
        $clientUser = User::find($scheduler->client_user_id);

        if (!$clientUser) {
            return back()->withErrors('Usuario cliente no encontrado')->withInput();
        }

        $service = $scheduler->service;
        $from = Carbon::parse($request->input('from.date') . ' ' . $request->input('from.time'));
        $to = Carbon::parse($from)->addMinutes($service->duration);

        $request->checkRescheduleRules($scheduler, $staffUser, $clientUser, $from, $to, $service);

        $scheduler->update([
            'from' => $from,
            'to' => $to,
        ]);

        return redirect()->route('staff-scheduler.index', [
            'date' => $from->format('Y-m-d')
        ])->with('success', 'Cita actualizada con éxito.');
    }

    public function destroy(Scheduler $scheduler)
    {
        $scheduler->load(['clientUser', 'staffUser']);
        
        $user = auth()->user();
        
        if (!$scheduler) {
            return redirect()->route('my-schedule.index')->withErrors('Cita no encontrada.');
        }

        if ($scheduler->client_user_id != $user->id && $scheduler->staff_user_id != $user->id) {
            return back()->withErrors('No tienes permiso para cancelar esta cita.');
        }

        $scheduler->delete();

        return redirect()->route('my-schedule.index')->with('success', 'Cita eliminada con éxito.');
    }
}
