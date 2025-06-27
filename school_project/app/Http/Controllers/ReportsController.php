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

    /**
     * Display a listing of class-wise collective fees.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function collectiveFees(Request $request)
    {
        $fromMonth = $request->input('from_month');
        $fromYear = $request->input('from_year');
        $toMonth = $request->input('to_month');
        $toYear = $request->input('to_year');

        // Get distinct fee types from add_fees
        $feeTypes = DB::table('add_fees')->distinct()->pluck('fee_type')->toArray();

        // Build query for collective fees
        $query = DB::table('challans')
            ->join('admission_forms', function ($join) {
                $join->on('challans.class', '=', 'admission_forms.class')
                     ->on('challans.section', '=', 'admission_forms.section')
                     ->on('challans.gr_number', '=', 'admission_forms.roll');
            })
            ->join('fees', function ($join) {
                $join->on('challans.class', '=', 'fees.class')
                     ->on('challans.section', '=', 'fees.section');
            })
            ->select(
                'fees.class',
                'fees.section',
                'fees.month',
                'fees.year'
            );

        // Add dynamic fee type columns using challans.total_fee
        foreach ($feeTypes as $feeType) {
            $query->selectRaw("SUM(CASE WHEN fees.fee_type = ? THEN challans.total_fee ELSE 0 END) as fee_type_".str_replace(' ', '_', $feeType), [$feeType]);
        }

        // Add total fees
        $query->selectRaw('SUM(challans.total_fee) as total_fees');

        // Apply date filters if provided
        if ($fromMonth && $fromYear && $toMonth && $toYear) {
            $fromDate = \Carbon\Carbon::createFromDate($fromYear, array_search($fromMonth, ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']) + 1, 1);
            $toDate = \Carbon\Carbon::createFromDate($toYear, array_search($toMonth, ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']) + 1, 1)->endOfMonth();
            $query->whereBetween('fees.year', [$fromYear, $toYear])
                  ->whereRaw("STR_TO_DATE(CONCAT(fees.month, ' 1, ', fees.year), '%M %d, %Y') BETWEEN ? AND ?", [$fromDate, $toDate]);
        }

        $collectiveFees = $query->groupBy('fees.class', 'fees.section', 'fees.month', 'fees.year')
                               ->get()
                               ->map(function ($item) use ($feeTypes) {
                                   $item->fee_types = [];
                                   foreach ($feeTypes as $feeType) {
                                       $key = 'fee_type_' . str_replace(' ', '_', $feeType);
                                       $item->fee_types[$feeType] = $item->$key;
                                       unset($item->$key);
                                   }
                                   return $item;
                               });

        return view('reports.collectivefees', compact('collectiveFees', 'feeTypes'));
    }

    /**
     * Display detailed fees for a specific class, section, month, and year.
     *
     * @param string $class
     * @param string $section
     * @param string $month
     * @param string $year
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function collectiveFeesDetails($class, $section, $month, $year)
    {
        $feeTypes = DB::table('add_fees')->distinct()->pluck('fee_type')->toArray();

        $query = DB::table('challans')
            ->join('admission_forms', function ($join) {
                $join->on('challans.class', '=', 'admission_forms.class')
                     ->on('challans.section', '=', 'admission_forms.section')
                     ->on('challans.gr_number', '=', 'admission_forms.roll');
            })
            ->join('fees', function ($join) {
                $join->on('challans.class', '=', 'fees.class')
                     ->on('challans.section', '=', 'fees.section');
            })
            ->select(
                'admission_forms.full_name',
                'admission_forms.roll',
                'challans.status'
            );

        foreach ($feeTypes as $feeType) {
            $query->selectRaw("SUM(CASE WHEN fees.fee_type = ? THEN challans.total_fee ELSE 0 END) as fee_type_".str_replace(' ', '_', $feeType), [$feeType]);
        }

        $query->selectRaw('SUM(challans.total_fee) as total_fees');

        $details = $query->where('challans.class', $class)
                         ->where('challans.section', $section)
                         ->where('fees.month', $month)
                         ->where('fees.year', $year)
                         ->groupBy('admission_forms.full_name', 'admission_forms.roll', 'challans.status')
                         ->get()
                         ->map(function ($item) use ($feeTypes) {
                             $item->fee_types = [];
                             foreach ($feeTypes as $feeType) {
                                 $key = 'fee_type_' . str_replace(' ', '_', $feeType);
                                 $item->fee_types[$feeType] = $item->$key;
                                 unset($item->$key);
                             }
                             return $item;
                         });

        return view('reports.collectivefeesdetails', compact('details', 'feeTypes', 'class', 'section', 'month', 'year'));
    }
}