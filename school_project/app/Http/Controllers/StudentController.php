<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function allstudent()
    {
        return view('student.allstudents');
    }

    public function studentDetails()
    {
        return view('student.studentdetails');
    }

    public function studentPromotion()
    {
        return view('student.studentpromotion');
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
        return view('student.admissionform');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
{
    // Validate input
    $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'gender' => 'required',
        'dob' => 'required',
        'roll' => 'nullable',
        'blood_group' => 'required',
        'religion' => 'required',
        'email' => 'nullable|email',
        'class' => 'required',
        'section' => 'required',
        'admission_id' => 'nullable',
        'phone' => 'nullable',
        'bio' => 'nullable',
        'photo' => 'nullable|image|max:2048',
    ]);

    // Handle file upload
    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('student_photos', 'public');
    }

    // Insert into database using DB query
    DB::table('admission_forms')->insert([
        'first_name'    => $request->first_name,
        'last_name'     => $request->last_name,
        'gender'        => $request->gender,
        'dob'           => $request->dob,
        'roll'          => $request->roll,
        'blood_group'   => $request->blood_group,
        'religion'      => $request->religion,
        'email'         => $request->email,
        'class'         => $request->class,
        'section'       => $request->section,
        'admission_id'  => $request->admission_id,
        'phone'         => $request->phone,
        'bio'           => $request->bio,
        'photo'         => $photoPath,
        'created_at'    => now(),
        'updated_at'    => now(),
    ]);

    return redirect()->back()->with('success', 'Student data saved using query builder.');
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
