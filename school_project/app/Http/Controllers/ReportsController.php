<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Display a listing of class-wise student counts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function totalStudents()
    {
        $classWiseStudents = DB::table('admission_forms')
            ->select(
                'class',
                'section',
                DB::raw('SUM(CASE WHEN gender = "female" THEN 1 ELSE 0 END) as girls'),
                DB::raw('SUM(CASE WHEN gender = "male" THEN 1 ELSE 0 END) as boys'),
                DB::raw('COUNT(*) as total_students')
            )
            ->groupBy('class', 'section')
            ->get();

        return view('reports.listtotalstudents', compact('classWiseStudents'));
    }

    /**
     * Display details of students in a specific class and section.
     *
     * @param string $class
     * @param string $section
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function classDetails($class, $section)
    {
        $students = DB::table('admission_forms')
            ->where('class', $class)
            ->where('section', $section)
            ->select('id', 'academic_session', 'class', 'section', 'student_name', 'gender', 'roll_number')
            ->get();

        return view('reports.classdetails', compact('students', 'class', 'section'));
    }

    /**
     * Delete a student record.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteStudent($id)
    {
        DB::table('admission_forms')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Student deleted successfully.');
    }
}