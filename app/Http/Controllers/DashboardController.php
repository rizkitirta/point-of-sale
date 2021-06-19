<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = Carbon::tomorrow()->format('l d-M-Y');

        dd($data);
        return view('dashboard.index');
    }
}
