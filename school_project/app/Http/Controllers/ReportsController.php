<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    
    public function totalStudents()
    {
        return view('reports.listtotalstudents');
    }

    
}
