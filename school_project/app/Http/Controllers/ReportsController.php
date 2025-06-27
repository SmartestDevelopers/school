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
            ->paginate(10);

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
            ->select('id', 'class', 'section', 'full_name', 'gender', 'roll')
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

    /**
     * Display a listing of class-wise fees.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function totalFees()
    {
        $classWiseFees = DB::table('admission_forms')
            ->leftJoin('challans', function ($join) {
                $join->on('admission_forms.class', '=', 'challans.class')
                     ->on('admission_forms.section', '=', 'challans.section')
                     ->on('admission_forms.roll', '=', 'challans.gr_number');
            })
            ->select(
                'admission_forms.class',
                'admission_forms.section',
                DB::raw('COUNT(DISTINCT admission_forms.id) as total_students'),
                DB::raw('COALESCE(SUM(challans.total_fee), 0) as expected_fee'),
                DB::raw('COALESCE(SUM(CASE WHEN challans.status = "Unpaid" THEN challans.total_fee ELSE 0 END), 0) as unpaid_fee'),
                DB::raw('COALESCE(SUM(CASE WHEN challans.status = "Paid" THEN challans.total_fee ELSE 0 END), 0) as paid_fee')
            )
            ->groupBy('admission_forms.class', 'admission_forms.section')
            ->get();

        return view('reports.listtotalfees', compact('classWiseFees'));
    }
}