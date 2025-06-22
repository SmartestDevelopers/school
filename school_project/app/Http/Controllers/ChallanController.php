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
        return view('acconunt.createchallan', compact('challans'));
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
                'month' => 'required_if:months_option,one|string',
                'year' => 'required_if:months_option,one|integer',
                'from_month' => 'required_if:months_option,many|string',
                'from_year' => 'required_if:months_option,many|integer',
                'to_month' => 'required_if:months_option,many|string',
                'to_year' => 'required_if:months_option,many|integer',
                'total_months' => 'required_if:months_option,many|integer|min:1',
                'student_id' => 'required_if:students_option,one|integer|exists:admission_forms,id',
            ]);

            Log::info('Validated data', $data);

            // Fetch students
            $students = $data['students_option'] === 'one'
                ? DB::table('admission_forms')
                    ->where('id', $data['student_id'])
                    ->select('id', 'full_name as name', 'parent_name', 'roll as gr')
                    ->get()
                : DB::table('admission_forms')
                    ->where('class', $data['class'])
                    ->where('section', $data['section'])
                    ->select('id', 'full_name as name', 'parent_name', 'roll as gr')
                    ->get();

            Log::info('Students found', ['count' => $students->count(), 'data' => $students->toArray()]);

            if ($students->isEmpty()) {
                Log::warning('No students found', ['class' => $data['class'], 'section' => $data['section']]);
                return redirect()->back()->with('error', 'No students found for the selected class and section.')->withInput();
            }

            DB::beginTransaction();

            // Determine months for fee calculation
            $months = $data['months_option'] === 'one'
                ? [['month' => $data['month'], 'year' => $data['year']]]
                : $this->getMonthRange($data['from_month'], $data['from_year'], $data['to_month'], $data['to_year']);

            foreach ($students as $student) {
                $totalFee = 0;

                // Calculate fees for each month
                foreach ($months as $monthData) {
                    $monthFee = DB::table('fees')
                        ->where('class', $data['class'])
                        ->where('section', $data['section'])
                        ->where('month', $monthData['month'])
                        ->where('year', $monthData['year'])
                        ->where('academic_year', $data['academic_year'])
                        ->sum('fee_amount');

                    if ($monthFee == 0) {
                        Log::warning('No fees found', [
                            'class' => $data['class'],
                            'section' => $data['section'],
                            'month' => $monthData['month'],
                            'year' => $monthData['year'],
                            'academic_year' => $data['academic_year']
                        ]);
                        DB::rollBack();
                        return redirect()->back()->with('error', "No fees found for {$monthData['month']} {$monthData['year']}.")->withInput();
                    }

                    $totalFee += $monthFee;
                }

                Log::info('Total fee calculated', [
                    'student_id' => $student->id,
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
                    'father_name' => $student->parent_name ?? 'N/A',
                    'gr_number' => $student->gr ?? 'N/A',
                    'academic_year' => $data['academic_year'],
                    'year' => $data['months_option'] === 'one' ? $data['year'] : $data['to_year'],
                    'from_month' => $data['month'] ?? $data['from_month'],
                    'from_year' => $data['year'] ?? $data['from_year'],
                    'to_month' => $data['to_month'] ?? null,
                    'to_year' => $data['to_year'] ?? null,
                    'total_fee' => $totalFee,
                    'status' => 'pending',
                    'due_date' => now()->addDays(30)->format('d/m/Y'),
                    'amount_in_words' => $this->numberToWords($totalFee),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            Log::info('Challan(s) created successfully');
            return redirect()->route('create-challan')->with('success', 'Challan(s) created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Challan creation failed: ' . $e->getMessage(), ['exception' => $e]);
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

        // Fetch all challans for the same class, section, academic_year, and period
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

        // Fetch fee details for each challan
        $fees = [];
        foreach ($challans as $ch) {
            $ch_fees = DB::table('fees')
                ->where('class', $ch->class)
                ->where('section', $ch->section)
                ->where('academic_year', $ch->academic_year)
                ->where('month', $ch->from_month)
                ->where('year', $ch->from_year)
                ->get(['fee_type', 'fee_amount']);
            $fees[$ch->id] = $ch_fees;
        }

        return view('acconunt.view-challan', compact('challans', 'fees', 'total_fee_sum', 'total_fee_sum_words'));
    }

    public function getStudents(Request $request)
    {
        Log::info('getStudents called', ['class' => $request->class, 'section' => $request->section]);
        $students = DB::table('admission_forms')
            ->where('class', $request->class)
            ->where('section', $request->section)
            ->select('id', 'full_name as name', 'roll as roll_number')
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

            // Fetch all challans for the same class, section, academic_year, and period
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

            // Fetch fee details for each challan
            $fees = [];
            foreach ($challans as $ch) {
                $ch_fees = DB::table('fees')
                    ->where('class', $ch->class)
                    ->where('section', $ch->section)
                    ->where('academic_year', $ch->academic_year)
                    ->where('month', $ch->from_month)
                    ->where('year', $ch->from_year)
                    ->get(['fee_type', 'fee_amount']);
                $fees[$ch->id] = $ch_fees;
            }

            $pdf = Pdf::loadView('acconunt.challan-pdf', compact('challans', 'fees', 'total_fee_sum', 'total_fee_sum_words'))
                ->setPaper('legal', 'landscape');
            return $pdf->download('challan-' . $id . '.pdf');
        } catch (\Exception $e) {
            Log::error('PDF generation failed: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('create-challan')->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    private function getMonthRange($fromMonth, $fromYear, $toMonth, $toYear)
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $start = array_search($fromMonth, $months);
        $end = array_search($toMonth, $months);
        $startYear = (int)$fromYear;
        $endYear = (int)$toYear;
        $monthRange = [];

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
        $number = (int)$number;
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