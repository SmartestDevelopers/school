<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ChallanController extends Controller
{
    public function create()
    {
        $challans = DB::table('challans')->orderBy('created_at', 'desc')->get();
        $students = DB::table('admission_forms')
            ->select('roll', 'full_name as name', 'roll as roll_number', 'class', 'section')
            ->get();
        return view('acconunt.createchallan', compact('challans', 'students'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'school_name' => 'required|string|max:255',
                'academic_year' => 'required|string',
                'class' => 'required|string',
                'section' => 'required|string',
                'months_option' => 'required|in:one,many',
                'students_option' => 'required|in:one,all',
                'month' => 'nullable|string|required_if:months_option,one',
                'year' => 'nullable|integer|required_if:months_option,one',
                'from_month' => 'nullable|string|required_if:months_option,many',
                'from_year' => 'nullable|integer|required_if:months_option,many',
                'to_month' => 'nullable|string|required_if:months_option,many',
                'to_year' => 'nullable|integer|required_if:months_option,many',
                'total_months' => 'nullable|integer|min:1|required_if:months_option,many',
                'roll' => 'nullable|string|required_if:students_option,one|exists:admission_forms,roll',
                'issue_date' => 'required|date',
                'due_date' => 'required|date|after_or_equal:issue_date',
                'account_number' => 'required|string',
            ]);

            Log::info('Validated data', ['data' => $data]);

            // Fetch students based on students_option
            $students = $data['students_option'] === 'one'
                ? DB::table('admission_forms')
                    ->where('roll', $data['roll'])
                    ->select('roll', 'full_name as name', 'parent_name as father_name', 'roll as gr')
                    ->get()
                : DB::table('admission_forms')
                    ->where('class', $data['class'])
                    ->where('section', $data['section'])
                    ->select('roll', 'full_name as name', 'parent_name as father_name', 'roll as gr')
                    ->get();

            if ($students->isEmpty()) {
                Log::warning('No students found', [
                    'class' => $data['class'],
                    'section' => $data['section'],
                    'students_option' => $data['students_option']
                ]);
                return redirect()->back()->with('error', 'No students found for the selected class and section.')->withInput();
            }

            DB::beginTransaction();

            // Generate months array
            $months = $data['months_option'] === 'one'
                ? [['month' => $data['month'], 'year' => $data['year']]]
                : $this->getMonthRange($data['from_month'], $data['from_year'], $data['to_month'], $data['to_year']);

            if (empty($months)) {
                Log::error('No months generated', [
                    'months_option' => $data['months_option'],
                    'month' => $data['month'] ?? null,
                    'year' => $data['year'] ?? null,
                    'from_month' => $data['from_month'] ?? null,
                    'from_year' => $data['from_year'] ?? null,
                    'to_month' => $data['to_month'] ?? null,
                    'to_year' => $data['to_year'] ?? null
                ]);
                DB::rollBack();
                return redirect()->back()->with('error', 'Invalid month range provided.')->withInput();
            }

            if ($data['students_option'] === 'all') {
                // Single challan for all students
                $totalFee = 0;
                $studentCount = $students->count();

                foreach ($months as $monthData) {
                    $monthFee = DB::table('fees')
                        ->where('class', $data['class'])
                        ->where('section', $data['section'])
                        ->where('month', $monthData['month'])
                        ->where('year', $monthData['year'])
                        ->where('academic_year', $data['academic_year'])
                        ->sum('fee_amount');

                    Log::info('Fee calculation for class', [
                        'class' => $data['class'],
                        'section' => $data['section'],
                        'month' => $monthData['month'],
                        'year' => $monthData['year'],
                        'academic_year' => $data['academic_year'],
                        'monthFee' => $monthFee
                    ]);

                    if ($monthFee == 0) {
                        Log::warning('No fees found for class', [
                            'class' => $data['class'],
                            'section' => $data['section'],
                            'month' => $monthData['month'],
                            'year' => $monthData['year'],
                            'academic_year' => $data['academic_year']
                        ]);
                        DB::rollBack();
                        return redirect()->back()->with('error', "No fees found for {$monthData['month']} {$monthData['year']}. Please ensure fee records exist.")->withInput();
                    }

                    // Multiply by student count to get total fee for the month
                    $totalFee += $monthFee * $studentCount;
                }

                Log::info('Total fee calculated for class', [
                    'class' => $data['class'],
                    'section' => $data['section'],
                    'total_fee' => $totalFee,
                    'student_count' => $studentCount
                ]);

                $monthsString = $data['months_option'] === 'one'
                    ? $data['month']
                    : "{$data['from_month']} {$data['from_year']} - {$data['to_month']} {$data['to_year']}";

                DB::table('challans')->insert([
                    'school_name' => $data['school_name'],
                    'class' => $data['class'],
                    'section' => $data['section'],
                    'full_name' => 'All Students',
                    'father_name' => 'N/A',
                    'gr_number' => 'Class-Wide',
                    'student_count' => $studentCount,
                    'academic_year' => $data['academic_year'],
                    'year' => $data['months_option'] === 'one' ? $data['year'] : $data['to_year'],
                    'from_month' => $data['months_option'] === 'one' ? $data['month'] : $data['from_month'],
                    'from_year' => $data['months_option'] === 'one' ? $data['year'] : $data['from_year'],
                    'to_month' => $data['months_option'] === 'many' ? $data['to_month'] : null,
                    'to_year' => $data['months_option'] === 'many' ? $data['to_year'] : null,
                    'total_fee' => $totalFee,
                    'status' => 'unpaid',
                    'due_date' => \Carbon\Carbon::parse($data['due_date'])->format('d/m/Y'),
                    'amount_in_words' => $this->numberToWords($totalFee),
                    'created_at' => \Carbon\Carbon::parse($data['issue_date']),
                    'updated_at' => now(),
                ]);
            } else {
                // Individual challans for one student
                foreach ($students as $student) {
                    $totalFee = 0;

                    foreach ($months as $monthData) {
                        $monthFee = DB::table('fees')
                            ->where('class', $data['class'])
                            ->where('section', $data['section'])
                            ->where('month', $monthData['month'])
                            ->where('year', $monthData['year'])
                            ->where('academic_year', $data['academic_year'])
                            ->sum('fee_amount');

                        Log::info('Fee calculation for student', [
                            'roll' => $student->roll,
                            'month' => $monthData['month'],
                            'year' => $monthData['year'],
                            'class' => $data['class'],
                            'section' => $data['section'],
                            'academic_year' => $data['academic_year'],
                            'monthFee' => $monthFee
                        ]);

                        if ($monthFee == 0) {
                            Log::warning('No fees found for student', [
                                'roll' => $student->roll,
                                'class' => $data['class'],
                                'section' => $data['section'],
                                'month' => $monthData['month'],
                                'year' => $monthData['year'],
                                'academic_year' => $data['academic_year']
                            ]);
                            DB::rollBack();
                            return redirect()->back()->with('error', "No fees found for {$monthData['month']} {$monthData['year']} for student {$student->roll}. Please ensure fee records exist.")->withInput();
                        }

                        $totalFee += $monthFee;
                    }

                    Log::info('Total fee calculated for student', [
                        'roll' => $student->roll,
                        'total_fee' => $totalFee
                    ]);

                    $monthsString = $data['months_option'] === 'one'
                        ? $data['month']
                        : "{$data['from_month']} {$data['from_year']} - {$data['to_month']} {$data['to_year']}";

                    DB::table('challans')->insert([
                        'school_name' => $data['school_name'],
                        'class' => $data['class'],
                        'section' => $data['section'],
                        'full_name' => $student->name,
                        'father_name' => $student->father_name ?? 'N/A',
                        'gr_number' => $student->roll,
                        'student_count' => 1,
                        'academic_year' => $data['academic_year'],
                        'year' => $data['months_option'] === 'one' ? $data['year'] : $data['to_year'],
                        'from_month' => $data['months_option'] === 'one' ? $data['month'] : $data['from_month'],
                        'from_year' => $data['months_option'] === 'one' ? $data['year'] : $data['from_year'],
                        'to_month' => $data['months_option'] === 'many' ? $data['to_month'] : null,
                        'to_year' => $data['months_option'] === 'many' ? $data['to_year'] : null,
                        'total_fee' => $totalFee,
                        'status' => 'unpaid',
                        'due_date' => \Carbon\Carbon::parse($data['due_date'])->format('d/m/Y'),
                        'amount_in_words' => $this->numberToWords($totalFee),
                        'created_at' => \Carbon\Carbon::parse($data['issue_date']),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            Log::info('Challan(s) created successfully', [
                'student_count' => $students->count(),
                'class' => $data['class'],
                'section' => $data['section'],
                'months_option' => $data['months_option']
            ]);
            return redirect()->route('create-challan')->with('success', 'Challan(s) created successfully for ' . $students->count() . ' student(s).');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors(), 'input' => $request->all()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Challan creation failed', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to create challan: ' . $e->getMessage())->withInput();
        }
    }

    public function view($id)
    {
        $challan = DB::table('challans')->where('id', $id)->first();
        if (!$challan) {
            Log::warning('Challan not found', ['id' => $id]);
            return redirect()->route('create-challan')->with('error', 'Challan not found.');
        }

        $challans = DB::table('challans')
            ->where('class', $challan->class)
            ->where('section', $challan->section)
            ->where('academic_year', $challan->academic_year)
            ->where('from_month', $challan->from_month)
            ->where('from_year', $challan->from_year)
            ->where(function ($query) use ($challan) {
                if ($challan->to_month && $challan->to_year) {
                    $query->where('to_month', $challan->to_month)
                          ->where('to_year', $challan->to_year);
                }
            })
            ->get();

        $total_fee_sum = $challans->sum('total_fee');
        $total_fee_sum_words = $this->numberToWords($total_fee_sum);

        $fee_types = DB::table('add_fees')->pluck('fee_type')->toArray();

        $fees = [];
        foreach ($challans as $ch) {
            $ch_fees = DB::table('fees')
                ->where('class', $ch->class)
                ->where('section', $ch->section)
                ->where('academic_year', $ch->academic_year)
                ->where('month', $ch->from_month)
                ->where('year', $ch->from_year)
                ->get(['fee_type', 'fee_amount']);
            
            $fee_data = array_fill_keys($fee_types, 0);
            foreach ($ch_fees as $fee) {
                if (in_array($fee->fee_type, $fee_types)) {
                    $fee_data[$fee->fee_type] = $fee->fee_amount;
                }
            }
            $fees[$ch->id] = $fee_data;
        }

        return view('acconunt.view-challan', compact('challan', 'challans', 'fees', 'total_fee_sum', 'total_fee_sum_words', 'fee_types'));
    }

    public function getStudents(Request $request)
    {
        Log::info('getStudents called', ['class' => $request->class, 'section' => $request->section]);
        $students = DB::table('admission_forms')
            ->where('class', $request->class)
            ->where('section', $request->section)
            ->select('roll', 'full_name as name', 'roll as roll_number')
            ->get();
        Log::info('Students fetched for dropdown', ['count' => $students->count(), 'data' => $students->toArray()]);
        return response()->json($students);
    }

    public function downloadPdf($id)
    {
        try {
            $challan = DB::table('challans')->where('id', $id)->first();
            if (!$challan) {
                Log::warning('Challan not found for PDF', ['id' => $id]);
                abort(404, 'Challan not found.');
            }

            $challans = DB::table('challans')
                ->where('class', $challan->class)
                ->where('section', $challan->section)
                ->where('academic_year', $challan->academic_year)
                ->where('from_month', $challan->from_month)
                ->where('from_year', $challan->from_year)
                ->where(function ($query) use ($challan) {
                    if ($challan->to_month && $challan->to_year) {
                        $query->where('to_month', $challan->to_month)
                              ->where('to_year', $challan->to_year);
                    }
                })
                ->get();

            $total_fee_sum = $challans->sum('total_fee');
            $total_fee_sum_words = $this->numberToWords($total_fee_sum);

            $fee_types = DB::table('add_fees')->pluck('fee_type')->toArray();

            $fees = [];
            foreach ($challans as $ch) {
                $ch_fees = DB::table('fees')
                    ->where('class', $ch->class)
                    ->where('section', $ch->section)
                    ->where('academic_year', $ch->academic_year)
                    ->where('month', $ch->from_month)
                    ->where('year', $ch->from_year)
                    ->get(['fee_type', 'fee_amount']);
                
                $fee_data = array_fill_keys($fee_types, 0);
                foreach ($ch_fees as $fee) {
                    if (in_array($fee->fee_type, $fee_types)) {
                        $fee_data[$fee->fee_type] = $fee->fee_amount;
                    }
                }
                $fees[$ch->id] = $fee_data;
            }

            $pdf = Pdf::loadView('acconunt.challan-pdf', compact('challan', 'challans', 'fees', 'total_fee_sum', 'total_fee_sum_words', 'fee_types'))
                ->setPaper('legal', 'landscape');
            return $pdf->download('challan-' . $id . '.pdf');
        } catch (\Exception $e) {
            Log::error('PDF generation failed', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('create-challan')->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    public function showPaidForm($id)
    {
        $challan = DB::table('challans')->where('id', $id)->first();
        if (!$challan) {
            Log::warning('Challan not found for paid form', ['id' => $id]);
            return redirect()->route('create-challan')->with('error', 'Challan not found.');
        }
        $students = DB::table('admission_forms')
            ->select('roll', 'full_name as name', 'roll as roll_number')
            ->get();
        return view('acconunt.challanpaid', compact('challan', 'students'));
    }

    public function markPaid(Request $request, $id)
    {
        try {
            $request->validate([
                'school_name' => 'required|string|max:255',
                'academic_year' => 'required|string',
                'class' => 'required|string',
                'section' => 'required|string',
                'month' => 'required|string',
                'year' => 'required|integer',
                'roll' => 'required|string|exists:admission_forms,roll',
            ]);

            $challan = DB::table('challans')
                ->where('id', $id)
                ->where('class', $request->class)
                ->where('section', $request->section)
                ->where('academic_year', $request->academic_year)
                ->where('from_month', $request->month)
                ->where('from_year', $request->year)
                ->first();

            if (!$challan) {
                Log::warning('Challan not found for marking paid', ['id' => $id]);
                return redirect()->route('create-challan')->with('error', 'Challan not found.');
            }

            DB::table('challans')
                ->where('id', $id)
                ->update([
                    'status' => 'paid',
                    'updated_at' => now(),
                ]);

            Log::info('Challan marked as paid', ['id' => $id]);
            return redirect()->route('create-challan')->with('success', 'Challan marked as paid successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to mark challan as paid', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('create-challan')->with('error', 'Failed to mark challan as paid: ' . $e->getMessage());
        }
    }

    private function getMonthRange($fromMonth, $fromYear, $toMonth, $toYear)
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $start = array_search($fromMonth, $months);
        $end = array_search($toMonth, $months);
        $startYear = (int) $fromYear;
        $endYear = (int) $toYear;
        $monthRange = [];

        if ($start === false || $end === false || $startYear > $endYear || ($startYear === $endYear && $start > $end)) {
            Log::error('Invalid month range', [
                'fromMonth' => $fromMonth,
                'fromYear' => $fromYear,
                'toMonth' => $toMonth,
                'toYear' => $toYear
            ]);
            return [];
        }

        while ($startYear < $endYear || ($startYear == $endYear && $start <= $end)) {
            $monthRange[] = [
                'month' => $months[$start],
                'year' => $startYear,
            ];
            $start++;
            if ($start > 11) {
                $start = 0;
                $startYear++;
            }
        }

        return $monthRange;
    }

    private function numberToWords($number)
    {
        $units = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
        $teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        $thousands = ['', 'Thousand', 'Million', 'Billion'];

        if ($number == 0) {
            return 'Zero';
        }

        $words = '';
        $number = (int) $number;
        $groupIndex = 0;

        while ($number > 0) {
            $group = $number % 1000;
            if ($group > 0) {
                $groupWords = '';
                $hundreds = (int)($group / 100);
                $remainder = $group % 100;

                if ($hundreds > 0) {
                    $groupWords .= $units[$hundreds] . ' Hundred';
                }

                if ($remainder > 0) {
                    if ($groupWords) {
                        $groupWords .= ' ';
                    }
                    if ($remainder < 10) {
                        $groupWords .= $units[$remainder];
                    } elseif ($remainder < 20) {
                        $groupWords .= $teens[$remainder - 10];
                    } else {
                        $tensDigit = (int)($remainder / 10);
                        $unitsDigit = $remainder % 10;
                        $groupWords .= $tens[$tensDigit];
                        if ($unitsDigit > 0) {
                            $groupWords .= ' ' . $units[$unitsDigit];
                        }
                    }
                }

                $groupWords .= ' ' . $thousands[$groupIndex];
                $words = trim($groupWords) . ($words ? ' ' . $words : '');
            }

            $number = (int)($number / 1000);
            $groupIndex++;
        }

        return strtoupper(trim($words) . ' ONLY');
    }
}