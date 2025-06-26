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

    public function feeReports(Request $request)
    {
        try {
            // Class-wise fee report (total fee amount, paid, unpaid per class)
            $classWiseFeeReport = DB::table('fee_challans')
                ->select(
                    'class',
                    DB::raw('SUM(fee_amount) as total_fee'),
                    DB::raw('SUM(paid_amount) as total_paid'),
                    DB::raw('SUM(fee_amount - paid_amount) as total_unpaid')
                )
                ->groupBy('class')
                ->orderBy('class')
                ->get();

            // Class-wise student fee history (last 12 months)
            $classWiseFeeHistory = DB::table('fee_challans as fc')
                ->join('admission_forms as af', 'fc.student_id', '=', 'af.id')
                ->select(
                    'fc.class',
                    'fc.student_id',
                    'af.full_name as student_name',
                    'fc.roll',
                    'fc.month',
                    'fc.year',
                    'fc.fee_amount',
                    'fc.paid_amount',
                    'fc.status',
                    DB::raw('fc.fee_amount - fc.paid_amount as unpaid_amount')
                )
                ->where('fc.created_at', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 12 MONTH)'))
                ->orderBy('fc.class')
                ->orderBy('fc.roll')
                ->orderBy('fc.year')
                ->orderBy('fc.month')
                ->get();

            // Class-wise number of months fee paid/unpaid
            $classWiseMonthsStatus = DB::table('fee_challans')
                ->select(
                    'class',
                    DB::raw('SUM(CASE WHEN status = "paid" THEN 1 ELSE 0 END) as months_paid'),
                    DB::raw('SUM(CASE WHEN status = "unpaid" THEN 1 ELSE 0 END) as months_unpaid')
                )
                ->where('created_at', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 12 MONTH)'))
                ->groupBy('class')
                ->orderBy('class')
                ->get();

            // Student-specific fee payment status for last 12 months
            $studentFeeStatus = DB::table('fee_challans as fc')
                ->join('admission_forms as af', 'fc.student_id', '=', 'af.id')
                ->select(
                    'fc.class',
                    'fc.student_id',
                    'af.full_name as student_name',
                    'fc.roll',
                    DB::raw('GROUP_CONCAT(CASE WHEN fc.status = "paid" THEN CONCAT(fc.month, "-", fc.year) END) as paid_months'),
                    DB::raw('GROUP_CONCAT(CASE WHEN fc.status = "unpaid" THEN CONCAT(fc.month, "-", fc.year) END) as unpaid_months'),
                    DB::raw('SUM(fc.paid_amount) as total_paid'),
                    DB::raw('SUM(fc.fee_amount - fc.paid_amount) as total_unpaid')
                )
                ->where('fc.created_at', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 12 MONTH)'))
                ->groupBy('fc.class', 'fc.student_id', 'af.full_name', 'fc.roll')
                ->orderBy('fc.class')
                ->orderBy('fc.roll')
                ->get();

            return view('reports.feereports', compact('classWiseFeeReport', 'classWiseFeeHistory', 'classWiseMonthsStatus', 'studentFeeStatus'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch fee reports: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load fee reports: ' . $e->getMessage());
        }
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