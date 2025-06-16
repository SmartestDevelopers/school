<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    /**
     * Display the form to add/edit fee types and list existing fee types.
     *
     * @return \Illuminate\Http\Response
     */
    public function addFee()
    {
        $fees = DB::table('add_fees')->get();
        return view('acconunt.listfeetype', compact('fees'));
    }

    /**
     * Store a newly created fee type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        return redirect()->back()->with('success', 'Fee added successfully!');
    }

    /**
     * Show the form for editing a fee type.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fees = DB::table('add_fees')->get();
        $editFee = DB::table('add_fees')->where('id', $id)->first();
        
        if (!$editFee) {
            return redirect()->route('addfeetype')->with('error', 'Fee type not found.');
        }

        return view('acconunt.listfeetype', compact('fees', 'editFee'));
    }

    /**
     * Update the specified fee type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            return redirect()->route('addfeetype')->with('success', 'Fee updated successfully!');
        } else {
            return redirect()->route('addfeetype')->with('error', 'Fee type not found or no changes made.');
        }
    }
}