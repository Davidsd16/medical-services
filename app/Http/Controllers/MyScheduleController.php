<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyScheduleController extends Controller
{
    public function index(Request $request)
    {
        // Obtener la fecha de la solicitud
        $date = $request->query('date', 'No date selected');

        // Retornar la vista con la variable date
        return view('my-schedule.index', compact('date'));
    }
}