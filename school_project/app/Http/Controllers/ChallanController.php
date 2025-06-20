<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use NumberFormatter;

class ChallanController extends Controller
{
    public function create()
    {
        $challans = DB::table('challans')->get();
        return view('acconunt.createchallan', compact('challans'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'school_name' => 'required|string|max:255',
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
                'student_id' => 'required_if:students_option,one|integer',
            ]);

            Log::info('Validated data', $data);

            $students = $data['students_option'] === 'one'
                ? DB::table('admission_forms')->where('id', $data['student_id'])->select('id', 'full_name as name', 'father_name', 'gr')->get()
                : DB::table('admission_forms')->where('class', $data['class'])->where('section', $data['section'])->select('id', 'full_name as name', 'father_name', 'gr')->get();

            Log::info('Students found', ['count' => $students->count(), 'data' => $students->toArray()]);

            if ($students->isEmpty()) {
                Log::warning('No students found', ['class' => $data['class'], 'section' => $data['section']]);
                return redirect()->back()->with('error', 'No students found for the selected class and section.')->withInput();
            }

            DB::beginTransaction();

            foreach ($students as $student) {
                $feeGroup = DB::table('fee_groups')
                    ->where('class', $data['class'])
                    ->where('section', $data['section'])
                    ->where('month', $data['month'] ?? $data['from_month'])
                    ->where('year', $data['year'] ?? $data['from_year'])
                    ->first();

                Log::info('Fee group query', [
                    'class' => $data['class'],
                    'section' => $data['section'],
                    'month' => $data['month'] ?? $data['from_month'],
                    'year' => $data['year'] ?? $data['from_year'],
                    'result' => $feeGroup ? (array)$feeGroup : null
                ]);

                if (!$feeGroup) {
                    Log::warning('No fee group found', [
                        'class' => $data['class'],
                        'section' => $data['section'],
                        'month' => $data['month'] ?? $data['from_month'],
                        'year' => $data['year'] ?? $data['from_year']
                    ]);
                    DB::rollBack();
                    return redirect()->back()->with('error', 'No fee group found for the selected criteria.')->withInput();
                }

                $totalFee = DB::table('fees')
                    ->where('fee_group_id', $feeGroup->id)
                    ->sum('fee_amount') * ($data['total_months'] ?? 1);

                Log::info('Total fee calculated', ['fee_group_id' => $feeGroup->id, 'total_fee' => $totalFee]);

                DB::table('challans')->insert([
                    'school_name' => $data['school_name'],
                    'class' => $data['class'],
                    'section' => $data['section'],
                    'full_name' => $student->name,
                    'father_name' => $student->father_name ?? 'N/A',
                    'gr_number' => $student->gr ?? 'N/A',
                    'academic_year' => ($data['year'] ?? $data['from_year']) . '-' . (($data['year'] ?? $data['from_year']) + 1),
                    'year' => $data['year'] ?? $data['from_year'],
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
            Log::error('Challan creation failed: ' . $e->getMessage());
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
        return view('acconunt.view-challan', compact('challan'));
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

            $feeGroup = DB::table('fee_groups')
                ->where('class', $challan->class)
                ->where('section', $challan->section)
                ->where('month', $challan->from_month)
                ->where('year', $challan->from_year)
                ->first();

            if (!$feeGroup) {
                Log::warning('No fee group found for PDF', ['challan_id' => $id]);
                return redirect()->route('create-challan')->with('error', 'No fee group found for this challan.');
            }

            $fees = DB::table('fees')->where('fee_group_id', $feeGroup->id)->get();
            $pdf = Pdf::loadView('acconunt.challan-pdf', compact('challan', 'fees'));
            return $pdf->download('challan-' . $challan->id . '.pdf');
        } catch (\Exception $e) {
            Log::error('PDF generation failed: ' . $e->getMessage());
            return redirect()->route('create-challan')->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    private function numberToWords($number)
    {
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        return strtoupper($formatter->format($number) . ' ONLY');
    }
}