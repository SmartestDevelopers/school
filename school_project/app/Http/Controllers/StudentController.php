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
        //echo "line 18";
        //echo "<br>";
        $admission_forms_array = DB::table('admission_forms')->get();
       // print_r($admission_forms);
        
        
       
        return view('student.allstudents', compact('admission_forms_array'));
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
        
        // here we will add table where we can see record inserted record, stored record
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // here we add form so that from this form we can insert recrod
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

    public function viewStudent($id)
    {
        $getStudentByID = DB::table('admission_forms')->where('id', $id)->first();    
        // print_r($getStudentByID);
        return view('student.viewAdmissionform', compact('getStudentByID'));

    }

    public function deleteStudent($id)
    {
        
        DB::table('admission_forms')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Student deleted successfully.');
    }

     public function editStudent($id)
    {
        $getStudentByID = DB::table('admission_forms')->where('id', $id)->first();    
        print_r($getStudentByID);
    }
}
