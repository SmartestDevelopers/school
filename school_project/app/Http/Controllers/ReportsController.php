<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportsController extends Controller
{
    public function totalStudents(Request $request)
    {
        try {
            // Fetch aggregated student counts grouped by school, class, section
            $classWiseStudents = DB::table('admission_forms')
                ->select(
                    'school_name',
                    'class',
                    'section',
                    DB::raw('COUNT(*) as total_students')
                )
                ->groupBy('school_name', 'class', 'section')
                ->orderBy('class')
                ->orderBy('section')
                ->get();

            // If class and section are provided (for detailed view)
            $detailedStudents = null;
            if ($request->has('class') && $request->has('section')) {
                $detailedStudents = DB::table('admission_forms')
                    ->select(
                        'id',
                        'school_name',
                        'class',
                        'section',
                        'full_name as student_name',
                        'roll',
                        DB::raw('CONCAT(YEAR(created_at), "-", YEAR(created_at) + 1) as academic_session')
                    )
                    ->where('class', $request->class)
                    ->where('section', $request->section)
                    ->orderBy('roll')
                    ->get();
            }

            return view('reports.listtotalstudents', compact('classWiseStudents', 'detailedStudents'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch student reports: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load student reports: ' . $e->getMessage());
        }
    }

    public function deleteStudent($id)
    {
        try {
            $student = DB::table('admission_forms')->where('id', $id)->first();
            if (!$student) {
                Log::warning('Student not found for deletion', ['id' => $id]);
                return redirect()->back()->with('error', 'Student not found.');
            }

            DB::table('admission_forms')->where('id', $id)->delete();
            Log::info('Student deleted successfully', ['id' => $id]);
            return redirect()->back()->with('success', 'Student deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete student: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
    }

    public function totalFees()
    {
        return view("reports.listtotalfees");
    }

    public function collectiveFees()
    {
        return view("reports.collectivefees");
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}