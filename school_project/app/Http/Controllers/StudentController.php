<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function allstudent()
    {
        $admission_forms_array = DB::table('admission_forms')->get();
        return view('student.allstudents', compact('admission_forms_array'));
    }

    public function studentPromotion()
    {
        return view('student.studentpromotion');
    }

    public function index()
    {
        // Placeholder for future table view
    }

    public function create()
    {
        $parents_array = DB::table('parents')->get();
        $teachers_array = DB::table('teachers')->get();
        return view('student.admissionform', compact('parents_array', 'teachers_array'));
    }

    function fetch_parent_name(Request $request)
    {
     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = DB::table('parents')
        ->where('full_name', 'LIKE', "%{$query}%")
        ->get();
      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      foreach($data as $row)
      {
       $output .= '
       <li><a href="#">'.$row->full_name.'</a></li>
       ';
      }
      $output .= '</ul>';
      echo $output;
     }
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'full_name' => 'required',
            'parent_name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'roll' => 'nullable',
            'blood_group' => 'required',
            'religion' => 'required',
            'email' => 'nullable|email',
            'class' => 'required',
            'section' => 'required',
            'teacher_name' => 'required',
            'admission_id' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'photo' => 'nullable|image|max:2048',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Handle file upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('student_photos', 'public');
            }

            // Insert into database
            DB::table('admission_forms')->insert([
                'full_name' => $request->full_name,
                'parent_name' => $request->parent_name,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'roll' => $request->roll,
                'blood_group' => $request->blood_group,
                'religion' => $request->religion,
                'email' => $request->email,
                'class' => $request->class,
                'section' => $request->section,
                'teacher_name' => $request->teacher_name,
                'admission_id' => $request->admission_id,
                'phone' => $request->phone,
                'address' => $request->address,
                'photo' => $photoPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Commit the transaction
            DB::commit();

            return redirect()->route('allstudent')->with('success', 'Student data saved successfully.');
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollback();

            // Log the error for debugging
            Log::error('Failed to save student data: ' . $e->getMessage(), [
                'request' => $request->all(),
            ]);

            // Return error message to user
            return redirect()->back()->with('error', 'Failed to save student data: ' . $e->getMessage());
        }
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

    public function viewStudent($id)
    {
        $getStudentByID = DB::table('admission_forms')->where('id', $id)->first();
        return view('student.viewAdmissionform', compact('getStudentByID'));
    }

    public function deleteStudent($id)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            // Check if student exists
            $student = DB::table('admission_forms')->where('id', $id)->first();
            if (!$student) {
                throw new \Exception('Student not found.');
            }

            // Delete the student
            DB::table('admission_forms')->where('id', $id)->delete();

            // Commit the transaction
            DB::commit();

            return redirect()->back()->with('success', 'Student deleted successfully.');
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollback();

            // Log the error
            Log::error('Failed to delete student: ' . $e->getMessage(), [
                'student_id' => $id,
            ]);

            return redirect()->back()->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
    }

    public function editStudent($id)
    {
        $getStudentByID = DB::table('admission_forms')->where('id', $id)->first();
        return view('student.editAdmissionform', compact('getStudentByID'));
    }

    public function updateStudent(Request $request)
    {
        // Validate input
        $request->validate([
            'id' => 'required|exists:admission_forms,id',
            'full_name' => 'required',
            'parent_name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'roll' => 'nullable',
            'blood_group' => 'required',
            'religion' => 'required',
            'email' => 'nullable|email',
            'class' => 'required',
            'section' => 'required',
            'teacher_name' => 'required',
            'admission_id' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Update the student record
            DB::table('admission_forms')
                ->where('id', $request->id)
                ->update([
                    'full_name' => $request->full_name,
                    'parent_name' => $request->parent_name,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'roll' => $request->roll,
                    'blood_group' => $request->blood_group,
                    'religion' => $request->religion,
                    'email' => $request->email,
                    'class' => $request->class,
                    'section' => $request->section,
                    'teacher_name' => $request->teacher_name,
                    'admission_id' => $request->admission_id,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'updated_at' => now(),
                ]);

            // Commit the transaction
            DB::commit();

            return redirect()->route('allstudent')->with('success', 'Student data updated successfully.');
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollback();

            // Log the error
            Log::error('Failed to update student data: ' . $e->getMessage(), [
                'student_id' => $request->id,
                'request' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Failed to update student data: ' . $e->getMessage());
        }
    }

    public function searchStudent(Request $request)
{
    try {
        // Get the search inputs
        $roll = $request->input('roll');
        $full_name = $request->input('full_name');
        $class = $request->input('class');

        // Build the query
        $query = DB::table('admission_forms');

        // Apply filters if provided
        if ($roll) {
            $query->where('roll', 'LIKE', "%{$roll}%");
        }

        if ($full_name) {
            $query->where('full_name', 'LIKE', "%{$full_name}%");
        }

        if ($class) {
            $query->where('class', 'LIKE', "%{$class}%");
        }

        // Execute the query and get the results
        $admission_forms_array = $query->get();

        // Return the view with the filtered results
        return view('student.allstudents', compact('admission_forms_array'));
    } catch (\Exception $e) {
        // Log the error for debugging
        Log::error('Failed to search students: ' . $e->getMessage(), [
            'request' => $request->all(),
        ]);

        // Redirect back with an error message
        return redirect()->back()->with('error', 'Failed to search students: ' . $e->getMessage());
    }
}
}