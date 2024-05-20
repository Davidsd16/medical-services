<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyScheduleController extends Controller
{
    public function index(){
        $date = request()->input('date');
        return view('dashboard')
        ->with([
            'date' => $date,
        ]);
    }
}
