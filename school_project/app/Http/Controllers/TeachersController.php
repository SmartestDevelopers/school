<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Correct placement

class TeachersController extends Controller
{
    public function allteacher()
    {
        //echo "line 18";
        //echo "<br>";
        $addteachers_array = DB::table('teachers')->get();
       // print_r($addteachers);
        
        
       
        return view('teacher.allteachers', compact('addteachers_array'));
    }

    public function teacherDetails()
    {
        return view('teacher.teacherdetails');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        return view('teacher.addteacher');
    }

    public function teacherPayment()
    {
        return view('teacher.teacherpayment');
    }

    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'gender'        => 'required|string',
            'dob'           => 'required',
            'id_no'         => 'nullable|string|max:50',
            'blood_group'   => 'required|string',
            'religion'      => 'required|string',
            'email'         => 'nullable|email|unique:teachers,email',
            'class'         => 'required|string',
            'section'       => 'required|string',
            'address'       => 'nullable|string',
            'phone'         => 'nullable|string|max:20',
            'bio'           => 'nullable|string',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // File upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/teachers'), $filename);
            $photoPath = 'uploads/teachers/' . $filename;
        }

        // Insert into database
        DB::table('teachers')->insert([
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'gender'      => $request->gender,
            'dob'         => $request->dob,
            'id_no'       => $request->id_no,
            'blood_group' => $request->blood_group,
            'religion'    => $request->religion,
            'email'       => $request->email,
            'class'       => $request->class,
            'section'     => $request->section,
            'address'     => $request->address,
            'phone'       => $request->phone,
            'bio'         => $request->bio,
            'photo'       => $photoPath,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'Teacher added successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function viewTeacher($id)
    {
        $getStudentByID = DB::table('admission_forms')->where('id', $id)->first();    
        // print_r($getStudentByID);
        return view('student.viewAdmissionform', compact('getStudentByID'));

    }

    public function deleteTeacher($id)
    {
        
        DB::table('teachers')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Teacher deleted successfully.');
    }

     public function editTeacher($id)
    {
        $getStudentByID = DB::table('teachers')->where('id', $id)->first();    
        print_r($getStudentByID);
    }
}
