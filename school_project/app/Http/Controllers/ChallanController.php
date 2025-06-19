<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use NumberFormatter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class ChallanController extends Controller
{
    public function create()
    {
        $challans = DB::table('challans')->get();
        Log::info('View paths: ' . json_encode(View::getFinder()->getPaths()));
        Log::info('Checking if view exists: createchallan');
        if (!View::exists('createchallan')) {
            Log::error('View createchallan not found');
            abort(500, 'View createchallan not found');
        }
        return view('createchallan', compact('challans'));
    }

    public function store(Request $request)
    {
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

        $students = $data['students_option'] === 'one'
            ? DB::table('students')->where('id', $data['student_id'])->get()
            : DB::table('students')->where('class', $data['class'])->where('section', $data['section'])->get();

        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'No students found for the selected class and section.');
        }

        foreach ($students as $student) {
            $feeGroup = DB::table('fee_groups')
                ->where('class', $data['class'])
                ->where('section', $data['section'])
                ->where('month', $data['month'] ?? $data['from_month'])
                ->where('year', $data['year'] ?? $data['from_year'])
                ->first();

            if (!$feeGroup) {
                return redirect()->back()->with('error', 'No fee group found for the selected criteria.');
            }

            $totalFee = DB::table('fees')
                ->where('fee_group_id', $feeGroup->id)
                ->sum('fee_amount') * ($data['total_months'] ?? 1);

            DB::table('challans')->insert([
                'school_name' => $data['school_name'],
                'class' => $data['class'],
                'section' => $data['section'],
                'student_name' => $student->name,
                'father_name' => $student->father_name ?? 'N/A',
                'gr_number' => $student->gr_number ?? 'N/A',
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
        $students = DB::table('students')
            ->where('class', $request->class)
            ->where('section', $request->section)
            ->select('id', 'name', 'roll_number')
            ->get();
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