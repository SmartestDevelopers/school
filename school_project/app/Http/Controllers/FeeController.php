<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Correct facade for v2.x

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
            'fee_type' => 'required|string|max:255',
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
            'fee_type' => 'required|string|max:255',
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
        $fees = DB::table('fees')->get();
        return view('acconunt.feemanagement', compact('feeTypes', 'fees'));
    }

    public function storeFee(Request $request)
    {
        $request->validate([
            'class' => 'required|string',
            'section' => 'required|string',
            'month' => 'required|string',
            'year' => 'required|numeric',
            'academic_year' => 'required|string',
            'fee_amounts' => 'required|array',
            'fee_amounts.*' => 'required|numeric|min:0',
        ]);

        foreach ($request->fee_amounts as $feeTypeId => $amount) {
            DB::table('fees')->insert([
                'class' => $request->class,
                'section' => $request->section,
                'month' => $request->month,
                'year' => $request->year,
                'academic_year' => $request->academic_year,
                'fee_type' => DB::table('add_fees')->where('id', $feeTypeId)->value('fee_type'),
                'fee_amount' => $amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Fees added successfully!');
    }

    public function editFee($id)
    {
        $feeTypes = DB::table('add_fees')->get();
        $fees = DB::table('fees')->get();
        $editFee = DB::table('fees')->where('id', $id)->first();

        if (!$editFee) {
            return redirect()->route('fee-management')->with('error', 'Fee record not found.');
        }

        return view('acconunt.feemanagement', compact('feeTypes', 'fees', 'editFee'));
    }

    public function updateFee(Request $request, $id)
    {
        $request->validate([
            'class' => 'required|string',
            'section' => 'required|string',
            'month' => 'required|string',
            'year' => 'required|numeric',
            'academic_year' => 'required|string',
            'fee_type' => 'required|string',
            'fee_amount' => 'required|numeric|min:0',
        ]);

        $updated = DB::table('fees')
            ->where('id', $id)
            ->update([
                'class' => $request->class,
                'section' => $request->section,
                'month' => $request->month,
                'year' => $request->year,
                'academic_year' => $request->academic_year,
                'fee_type' => $request->fee_type,
                'fee_amount' => $request->fee_amount,
                'updated_at' => now(),
            ]);

        if ($updated) {
            return redirect()->route('fee-management')->with('success', 'Fee updated successfully!');
        } else {
            return redirect()->route('fee-management')->with('error', 'Fee record not found or no changes made.');
        }
    }

    // Challan Actions
    public function createChallan()
    {
        $challans = DB::table('challans')->get();
        return view('acconunt.createchallan', compact('challans'));
    }

    public function storeChallan(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_branch' => 'required|string|max:255',
            'class' => 'required|string',
            'section' => 'required|string',
            'months' => 'required|integer|min:1',
            'students' => 'required|integer|min:1',
            'student_name' => 'required|string|max:255',
            'roll_number' => 'required|string|max:50',
            'academic_session' => 'required|string',
            'year' => 'required|numeric',
        ]);

        // Calculate total fee from fees table
        $fees = DB::table('fees')
            ->where('class', $request->class)
            ->where('section', $request->section)
            ->where('year', $request->year)
            ->where('academic_year', $request->academic_session)
            ->get();

        $totalFee = $fees->sum('fee_amount') * $request->months * $request->students;

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