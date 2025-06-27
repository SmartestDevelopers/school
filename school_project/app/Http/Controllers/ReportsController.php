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
        DB::connection()->disableQueryLog();

        $classWiseStudents = DB::table('admission_forms')
            ->select(
                'class',
                'section',
                DB::raw('SUM(CASE WHEN gender = "female" THEN 1 ELSE 0 END) as girls'),
                DB::raw('SUM(CASE WHEN gender = "male" THEN 1 ELSE 0 END) as boys'),
                DB::raw('COUNT(*) as total_students')
            )
            ->groupBy('class', 'section')
            ->orderBy('class', 'asc')
            ->orderBy('section', 'asc')
            ->get();

        \Log::info('ClassWiseStudents:', $classWiseStudents->toArray());
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
        DB::connection()->disableQueryLog();

        $students = DB::table('admission_forms')
            ->where('class', $class)
            ->where('section', $section)
            ->select('id', 'class', 'section', 'full_name', 'gender', 'roll')
            ->orderBy('roll', 'asc')
            ->get();

        \Log::info('ClassDetails:', ['class' => $class, 'section' => $section, 'students' => $students->toArray()]);
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
        DB::connection()->disableQueryLog();

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
        DB::connection()->disableQueryLog();

        $classWiseFees = DB::table('admission_forms')
            ->select(
                'admission_forms.class',
                'admission_forms.section',
                DB::raw('COUNT(DISTINCT admission_forms.id) as total_students'),
                DB::raw('COALESCE((
                    SELECT SUM(c.total_fee)
                    FROM challans c
                    WHERE c.class = admission_forms.class
                    AND c.section = admission_forms.section
                ), 0) as expected_fee'),
                DB::raw('COALESCE((
                    SELECT SUM(c.total_fee)
                    FROM challans c
                    WHERE c.class = admission_forms.class
                    AND c.section = admission_forms.section
                    AND c.status = "unpaid"
                ), 0) as unpaid_fee'),
                DB::raw('COALESCE((
                    SELECT SUM(c.total_fee)
                    FROM challans c
                    WHERE c.class = admission_forms.class
                    AND c.section = admission_forms.section
                    AND c.status = "paid"
                ), 0) as paid_fee')
            )
            ->groupBy('admission_forms.class', 'admission_forms.section')
            ->orderBy('admission_forms.class', 'asc')
            ->orderBy('admission_forms.section', 'asc')
            ->get();

        \Log::info('ClassWiseFees:', $classWiseFees->toArray());
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
        DB::connection()->disableQueryLog();

        $fromMonth = $request->input('from_month');
        $fromYear = $request->input('from_year');
        $toMonth = $request->input('to_month');
        $toYear = $request->input('to_year');

        // Get distinct fee types
        $feeTypes = DB::table('fees')->distinct()->pluck('fee_type')->toArray();
        if (DB::table('information_schema.tables')->where('table_name', 'add_fees')->exists()) {
            $feeTypes = array_unique(array_merge($feeTypes, DB::table('add_fees')->distinct()->pluck('fee_type')->toArray()));
        }

        // Get student counts per class and section
        $studentCounts = DB::table('admission_forms')
            ->select('class', 'section', DB::raw('COUNT(*) as student_count'))
            ->groupBy('class', 'section')
            ->get()
            ->keyBy(function ($item) {
                return $item->class . '-' . $item->section;
            })->toArray();

        // Build query for collective fees
        $query = DB::table('fees')
            ->select(
                'fees.class',
                'fees.section',
                'fees.month',
                'fees.year'
            );

        // Add dynamic fee type columns
        foreach ($feeTypes as $feeType) {
            $query->selectRaw(
                "SUM(CASE WHEN fees.fee_type = ? THEN fees.fee_amount ELSE 0 END) * COALESCE(
                    (SELECT COUNT(*) FROM admission_forms WHERE admission_forms.class = fees.class AND admission_forms.section = fees.section),
                    1
                ) as fee_type_".str_replace(' ', '_', $feeType),
                [$feeType]
            );
        }

        // Add total fees from challans
        $query->selectRaw(
            'COALESCE((
                SELECT SUM(c.total_fee)
                FROM challans c
                WHERE c.class = fees.class
                AND c.section = fees.section
                AND (
                    (c.from_month = fees.month AND c.from_year = fees.year AND c.to_month IS NULL)
                    OR (
                        c.gr_number = "Class-Wide"
                        AND fees.month BETWEEN c.from_month AND COALESCE(c.to_month, c.from_month)
                        AND c.from_year = fees.year
                    )
                )
            ), 0) as total_fees'
        );

        // Apply date filters if provided
        if ($fromMonth && $fromYear && $toMonth && $toYear) {
            $monthMap = [
                'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'May' => 5, 'Jun' => 6,
                'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12
            ];
            $fromMonthNum = $monthMap[$fromMonth] ?? 1;
            $toMonthNum = $monthMap[$toMonth] ?? $fromMonthNum;
            $fromDate = \Carbon\Carbon::createFromDate($fromYear, $fromMonthNum, 1);
            $toDate = \Carbon\Carbon::createFromDate($toYear, $toMonthNum, 1)->endOfMonth();
            $query->whereBetween('fees.year', [$fromYear, $toYear])
                  ->whereRaw("STR_TO_DATE(CONCAT(fees.month, ' 1, ', fees.year), '%b %d, %Y') BETWEEN ? AND ?", [$fromDate, $toDate]);
        }

        $collectiveFees = $query->groupBy('fees.class', 'fees.section', 'fees.month', 'fees.year')
                               ->orderBy('class', 'asc')
                               ->orderBy('section', 'asc')
                               ->orderBy('year', 'asc')
                               ->orderByRaw("FIELD(month, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')")
                               ->get()
                               ->map(function ($item) use ($feeTypes, $studentCounts) {
                                   $item->fee_types = [];
                                   foreach ($feeTypes as $feeType) {
                                       $key = 'fee_type_' . str_replace(' ', '_', $feeType);
                                       $item->fee_types[$feeType] = $item->$key ?? 0;
                                       unset($item->$key);
                                   }
                                   $item->total_fees = $item->total_fees ?: array_sum($item->fee_types);
                                   return $item;
                               });

        \Log::info('CollectiveFees:', $collectiveFees->toArray());
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
        DB::connection()->disableQueryLog();

        $feeTypes = DB::table('fees')->distinct()->pluck('fee_type')->toArray();
        if (DB::table('information_schema.tables')->where('table_name', 'add_fees')->exists()) {
            $feeTypes = array_unique(array_merge($feeTypes, DB::table('add_fees')->distinct()->pluck('fee_type')->toArray()));
        }

        $studentCount = DB::table('admission_forms')
            ->where('class', $class)
            ->where('section', $section)
            ->count();

        $query = DB::table('admission_forms')
            ->leftJoin('challans', function ($join) use ($month, $year) {
                $join->on('challans.class', '=', 'admission_forms.class')
                     ->on('challans.section', '=', 'admission_forms.section')
                     ->whereRaw('challans.gr_number = admission_forms.roll OR challans.gr_number = "Class-Wide"')
                     ->where(function ($query) use ($month, $year) {
                         $query->where('challans.from_month', $month)
                               ->where('challans.from_year', $year)
                               ->whereNull('challans.to_month')
                               ->orWhere(function ($query) use ($month, $year) {
                                   $query->where('challans.gr_number', 'Class-Wide')
                                         ->whereRaw('? BETWEEN challans.from_month AND COALESCE(challans.to_month, challans.from_month)', [$month])
                                         ->where('challans.from_year', $year);
                               });
                     });
            })
            ->leftJoin('fees', function ($join) use ($month, $year) {
                $join->on('fees.class', '=', 'admission_forms.class')
                     ->on('fees.section', '=', 'admission_forms.section')
                     ->where('fees.month', $month)
                     ->where('fees.year', $year);
            })
            ->select(
                'admission_forms.full_name',
                'admission_forms.roll',
                DB::raw('COALESCE(challans.status, "No Challan") as status'),
                DB::raw('COALESCE(challans.total_fee / NULLIF(CASE WHEN challans.gr_number = "Class-Wide" THEN ? ELSE 1 END, 0), 0) as total_fees')
            )
            ->addBinding($studentCount, 'select');

        foreach ($feeTypes as $feeType) {
            $query->selectRaw("SUM(CASE WHEN fees.fee_type = ? THEN fees.fee_amount ELSE 0 END) as fee_type_".str_replace(' ', '_', $feeType), [$feeType]);
        }

        $details = $query->where('admission_forms.class', $class)
                         ->where('admission_forms.section', $section)
                         ->groupBy('admission_forms.full_name', 'admission_forms.roll', 'challans.status', 'challans.total_fee', 'challans.gr_number')
                         ->orderBy('roll', 'asc')
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

        \Log::info('CollectiveFeesDetails:', ['class' => $class, 'section' => $section, 'month' => $month, 'year' => $year, 'details' => $details->toArray()]);
        return view('reports.collectivefeesdetails', compact('details', 'feeTypes', 'class', 'section', 'month', 'year'));
    }
}
