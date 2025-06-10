<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allClass()
    {
        return view('class.allclass');
    }

    public function classRoutine()
    {
        return view('class_routine.classroutine');
    }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('class.addclass');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Optional: Validate the request
        $validated = $request->validate([
            'teacher_name' => 'required|string|max:255',
            'id_no'        => 'nullable|string|max:50',
            'gender'       => 'required|string',
            'class'        => 'required|string',
            'subject'      => 'required|string',
            'section'      => 'required|string',
            'time'         => 'required|string',
            'date'         => 'required|string',
            'phone'        => 'required|string|max:15',
            'email'        => 'required|email|max:255',
        ]);

        // You can store the data in database here
        // For now, just return a confirmation message

        // Get all form data
    $data = $request->all();

    // Insert into the class_forms_table
    $insert = DB::table('class_forms')->insert([
        'teacher_name' => $data['teacher_name'],
        'id_no'        => $data['id_no'],
        'gender'       => $data['gender'],
        'class'        => $data['class'],
        'subject'      => $data['subject'],
        'section'      => $data['section'],
        'time'         => $data['time'],
        'date'         => $data['date'],
        'phone'        => $data['phone'],
        'email'        => $data['email'],
        'created_at'   => now(),
        'updated_at'   => now(),
    ]);

    if ($insert) {
        return redirect()->back()->with('success', 'Class schedule submitted successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to submit class schedule.');
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
