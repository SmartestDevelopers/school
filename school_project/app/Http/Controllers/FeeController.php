<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    /**
     * Display the form to add a fee type and list existing fee types.
     *
     * @return \Illuminate\Http\Response
     */
    public function addFee()
    {
        // Fetch all fee types from the add_fees table
        $fees = DB::table('add_fees')->get();
        
        // Return the view with the fees data
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
}