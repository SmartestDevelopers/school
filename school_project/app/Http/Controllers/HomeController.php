<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the admin dashboard with dynamic data.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Count total students
        $studentCount = DB::table('admission_forms')->count();

        // Count total teachers
        $teacherCount = DB::table('teachers')->count();

        // Count total parents
        $parentCount = DB::table('parents')->count();

        // Sum total earnings from paid challans
        $earnings = DB::table('challans')
            ->where('status', 'paid')
            ->sum('total_fee');

        return view('home', compact('studentCount', 'teacherCount', 'parentCount', 'earnings'));
    }
}