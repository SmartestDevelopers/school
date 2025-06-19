<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class FeeController extends Controller
{
    // Fee Type Actions
    public function addFee()
    {
        $fees = DB::table('add_fees')->get();
        return view('acconunt.listfeetype', compact('fees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fee_type' => 'required|string|max:255|unique:add_fees,fee_type',
        ]);

        DB::table('add_fees')->insert([
            'fee_type' => $request->fee_type,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Fee type added successfully!');
    }

    public function edit($id)
    {
        $fees = DB::table('add_fees')->get();
        $editFee = DB::table('add_fees')->where('id', $id)->first();
        
        if (!$editFee) {
            return redirect()->route('addfeetype')->with('error', 'Fee type not found.');
        }

        return view('acconunt.listfeetype', compact('fees', 'editFee'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fee_type' => 'required|string|max:255|unique:add_fees,fee_type,' . $id,
        ]);

        $updated = DB::table('add_fees')
            ->where('id', $id)
            ->update([
                'fee_type' => $request->fee_type,
                'updated_at' => now(),
            ]);

        if ($updated) {
            return redirect()->route('addfeetype')->with('success', 'Fee type updated successfully!');
        } else {
            return redirect()->route('addfeetype')->with('error', 'Fee type not found or no changes made.');
        }
    }

    // Fee Management Actions
    public function manageFees()
    {
        $feeTypes = DB::table('add_fees')->get();
        // Group fees by class, section, month, year, academic_year
        $feeGroups = DB::table('fees')
            ->select('class', 'section', 'month', 'year', 'academic_year')
            ->groupBy('class', 'section', 'month', 'year', 'academic_year')
            ->paginate(10);

        // Attach fees to each group
        $feeGroups->getCollection()->transform(function ($group) {
            $group->fees = DB::table('fees')
                ->where('class', $group->class)
                ->where('section', $group->section)
                ->where('month', $group->month)
                ->where('year', $group->year)
                ->where('academic_year', $group->academic_year)
                ->get();
            return $group;
        });

        return view('acconunt.feemanagement', compact('feeTypes', 'feeGroups'));
    }

    public function storeFee(Request $request)
    {
        $request->validate([
            'class' => 'required|string',
            'section' => 'required|string',
            'month' => 'required|string',
            'year' => 'required|numeric',
            'academic_year' => 'required|string',
            'fee_types.*.type' => 'required|string|exists:add_fees,fee_type',
            'fee_types.*.amount' => 'required|numeric|min:0',
        ]);

        // Insert fees
        foreach ($request->fee_types as $feeType) {
            DB::table('fees')->insert([
                'class' => $request->class,
                'section' => $request->section,
                'month' => $request->month,
                'year' => $request->year,
                'academic_year' => $request->academic_year,
                'fee_type' => $feeType['type'],
                'fee_amount' => $feeType['amount'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('fee-management')->with('success', 'Fees added successfully!');
    }

    public function editFee($id)
    {
        $feeTypes = DB::table('add_fees')->get();
        // Group fees by class, section, month, year, academic_year
        $feeGroups = DB::table('fees')
            ->select('class', 'section', 'month', 'year', 'academic_year')
            ->groupBy('class', 'section', 'month', 'year', 'academic_year')
            ->paginate(10);

        // Attach fees to each group
        $feeGroups->getCollection()->transform(function ($group) {
            $group->fees = DB::table('fees')
                ->where('class', $group->class)
                ->where('section', $group->section)
                ->where('month', $group->month)
                ->where('year', $group->year)
                ->where('academic_year', $group->academic_year)
                ->get();
            return $group;
        });

        // Find the fee group by ID of one of its fees
        $editFee = DB::table('fees')->where('id', $id)->first();
        if (!$editFee) {
            return redirect()->route('fee-management')->with('error', 'Fee record not found.');
        }
        $editFeeGroup = (object) [
            'class' => $editFee->class,
            'section' => $editFee->section,
            'month' => $editFee->month,
            'year' => $editFee->year,
            'academic_year' => $editFee->academic_year,
            'fees' => DB::table('fees')
                ->where('class', $editFee->class)
                ->where('section', $editFee->section)
                ->where('month', $editFee->month)
                ->where('year', $editFee->year)
                ->where('academic_year', $editFee->academic_year)
                ->get(),
        ];

        return view('acconunt.feemanagement', compact('feeTypes', 'feeGroups', 'editFeeGroup'));
    }

    public function updateFee(Request $request, $id)
    {
        $request->validate([
            'class' => 'required|string',
            'section' => 'required|string',
            'month' => 'required|string',
            'year' => 'required|numeric',
            'academic_year' => 'required|string',
            'fee_types.*.type' => 'required|string|exists:add_fees,fee_type',
            'fee_types.*.amount' => 'required|numeric|min:0',
        ]);

        // Find the original fee group by ID of one of its fees
        $originalFee = DB::table('fees')->where('id', $id)->first();
        if (!$originalFee) {
            return redirect()->route('fee-management')->with('error', 'Fee record not found.');
        }

        // Delete existing fees for this group
        DB::table('fees')
            ->where('class', $originalFee->class)
            ->where('section', $originalFee->section)
            ->where('month', $originalFee->month)
            ->where('year', $originalFee->year)
            ->where('academic_year', $originalFee->academic_year)
            ->delete();

        // Insert updated fees
        foreach ($request->fee_types as $feeType) {
            DB::table('fees')->insert([
                'class' => $request->class,
                'section' => $request->section,
                'month' => $request->month,
                'year' => $request->year,
                'academic_year' => $request->academic_year,
                'fee_type' => $feeType['type'],
                'fee_amount' => $feeType['amount'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('fee-management')->with('success', 'Fees updated successfully!');
    }

    // Challan Actions
    public function createChallan()
    {
        $challans = DB::table('challans')->get();
        $classes = DB::table('fees')->distinct()->pluck('class');
        $sections = DB::table('fees')->distinct()->pluck('section');
        $academicYears = DB::table('fees')->distinct()->pluck('academic_year');
        return view('acconunt.createchallan', compact('challans', 'classes', 'sections', 'academicYears'));
    }

    public function storeChallan(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_branch' => 'required|string|max:255',
            'class' => 'required|string',
            'section' => 'required|string',
            'months' => 'required|string',
            'students' => 'required|string',
            'student_name' => 'required|string|max:255',
            'roll_number' => 'required|string|max:50',
            'academic_session' => 'required|string',
            'year' => 'required|numeric',
            'father_name' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'account_number' => 'required|string|max:255',
        ]);

        // Calculate total fee
        $fees = DB::table('fees')
            ->where('class', $request->class)
            ->where('section', $request->section)
            ->where('year', $request->year)
            ->where('academic_year', $request->academic_session)
            ->get();

        if ($fees->isEmpty()) {
            return redirect()->back()->with('error', 'No fees found for the specified class, section, and academic year.');
        }

        $totalFee = $fees->sum('fee_amount');

        DB::table('challans')->insert([
            'school_name' => $request->school_name,
            'school_branch' => $request->school_branch,
            'class' => $request->class,
            'section' => $request->section,
            'months' => $request->months,
            'students' => $request->students,
            'student_name' => $request->student_name,
            'roll_number' => $request->roll_number,
            'academic_session' => $request->academic_session,
            'year' => $request->year,
            'father_name' => $request->father_name,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'account_number' => $request->account_number,
            'total_fee' => $totalFee,
            'status' => 'unpaid',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Challan created successfully!');
    }

    public function viewChallan($id)
    {
        $challan = DB::table('challans')->where('id', $id)->first();
        if (!$challan) {
            return redirect()->route('create-challan')->with('error', 'Challan not found.');
        }

        $fees = DB::table('fees')
            ->where('class', $challan->class)
            ->where('section', $challan->section)
            ->where('year', $challan->year)
            ->where('academic_year', $challan->academic_session)
            ->get();

        // Generate PDF
        $pdf = Pdf::loadView('acconunt.challan_receipt', compact('challan', 'fees'));
        return $pdf->download('challan_' . $challan->id . '.pdf');
    }
}