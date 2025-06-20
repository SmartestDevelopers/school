<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use NumberFormatter;
use Illuminate\Support\Facades\Log;

class ChallanController extends Controller
{
    public function create()
    {
        $challans = DB::table('challans')->get();
        return view('acconunt.createchallan', compact('challans'));
    }

    public function store(Request $request)
    {
        \Log::info('Store method called', $request->all());

        
        $data = $request->validate([

            'school_name' => 'required|string',
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
        dd($data);

        \Log::info('Validated data', $data);

        $students = $data['students_option'] === 'one'
            ? DB::table('admission_forms')->where('id', $data['student_id'])->select('id', 'full_name as name', 'father_name', 'gr')->get()
            : DB::table('admission_forms')->where('class', $data['class'])->where('section', $data['section'])->select('id', 'full_name as name', 'father_name', 'gr')->get();

        \Log::info('Students found', ['count' => $students->count(), 'data' => $students->toArray()]);

        if ($students->isEmpty()) {
            \Log::warning('No students found', ['class' => $data['class'], 'section' => $data['section']]);
            return redirect()->back()->with('error', 'No students found for the selected class and section.');
        }

        foreach ($students as $student) {
            $feeGroup = DB::table('fee_groups')
                ->where('class', $data['class'])
                ->where('section', $data['section'])
                ->where('month', $data['month'] ?? $data['from_month'])
                ->where('year', $data['year'] ?? $data['from_year'])
                ->first();

            \Log::info('Fee group query', [
                'class' => $data['class'],
                'section' => $data['section'],
                'month' => $data['month'] ?? $data['from_month'],
                'year' => $data['year'] ?? $data['from_year'],
                'result' => $feeGroup ? (array)$feeGroup : null
            ]);

            if (!$feeGroup) {
                \Log::warning('No fee group found', [
                    'class' => $data['class'],
                    'section' => $data['section'],
                    'month' => $data['month'] ?? $data['from_month'],
                    'year' => $data['year'] ?? $data['from_year']
                ]);
                return redirect()->back()->with('error', 'No fee group found for the selected criteria.');
            }

            $totalFee = DB::table('fees')
                ->where('fee_group_id', $feeGroup->id)
                ->sum('fee_amount') * ($data['total_months'] ?? 1);

            \Log::info('Total fee calculated', ['fee_group_id' => $feeGroup->id, 'total_fee' => $totalFee]);

            DB::table('challans')->insert([
                'school_name' => $data['school_name'],
                'class' => $data['class'],
                'section' => $data['section'],
                'student_name' => $student->name,
                'father_name' => $student->father_name ?? 'N/A',
                'gr_number' => $student->gr ?? 'N/A',
                'academic_session' => ($data['year'] ?? $data['from_year']) . '-' . (($data['year'] ?? $data['from_year']) + 1),
                'year' => $data['year'] ?? $data['from_year'],
                'from_month' => $data['month'] ?? $data['from_month'],
                'from_year' => $data['year'] ?? $data['from_year'],
                'to_month' => $data['to_month'] ?? null,
                'to_year' => $data['to_year'] ?? null,
                'total_fee' => $totalFee,
                'status' => 'pending',
                'issued_on' => now()->format('d/m/Y'),
                'due_date' => now()->addDays(30)->format('d/m/Y'),
                'amount_in_words' => $this->numberToWords($totalFee),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        \Log::info('Challan(s) created successfully');

        return redirect()->route('create-challan')->with('success', 'Challan(s) created successfully.');
    }

    public function view($id)
    {
        $challan = DB::table('challans')->where('id', $id)->first();
        if (!$challan) {
            abort(404);
        }
        return view('view-challan', compact('challan'));
    }

    public function getStudents(Request $request)
    {
        \Log::info('getStudents called', ['class' => $request->class, 'section' => $request->section]);
        $students = DB::table('admission_forms')
            ->where('class', $request->class)
            ->where('section', $request->section)
            ->select('id', 'full_name as name', 'roll as roll_number')
            ->get();
        \Log::info('Students fetched for dropdown', ['count' => $students->count(), 'data' => $students->toArray()]);
        return response()->json($students);
    }

    public function downloadPdf($id)
    {
        $challan = DB::table('challans')->where('id', $id)->first();
        if (!$challan) {
            abort(404);
        }
        $pdf = Pdf::loadView('challan-pdf', compact('challan'));
        return $pdf->download('challan-' . $challan->id . '.pdf');
    }

    private function numberToWords($number)
    {
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        return strtoupper($formatter->format($number) . ' ONLY');
    }
}
