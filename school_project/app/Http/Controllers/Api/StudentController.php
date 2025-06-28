<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of students
     */
    public function index(Request $request)
    {

        try {
            $query = DB::table('admission_forms');
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('full_name', 'LIKE', "%{$search}%")
                      ->orWhere('admission_id', 'LIKE', "%{$search}%")
                      ->orWhere('roll', 'LIKE', "%{$search}%");
                });
            }
            
            // Filter by class
            if ($request->has('class')) {
                $query->where('class', $request->class);
            }
            
            // Filter by section
            if ($request->has('section')) {
                $query->where('section', $request->section);
            }
            
            $students = $query->paginate($request->get('per_page', 15));
            
            return response()->json([
                'success' => true,
                'message' => 'Students retrieved successfully',
                'data' => $students
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving students',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created student
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'parent_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'blood_group' => 'required|string',
            'religion' => 'required|string',
            'class' => 'required|string',
            'section' => 'required|string',
            'teacher_name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('student_photos', 'public');
            }

            $studentId = DB::table('admission_forms')->insertGetId([
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

            $student = DB::table('admission_forms')->where('id', $studentId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Student created successfully',
                'data' => $student
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating student',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified student
     */
    public function show($id)
    {
        try {
            $student = DB::table('admission_forms')->where('id', $id)->first();
            
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Student retrieved successfully',
                'data' => $student
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving student',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified student
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'parent_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'blood_group' => 'required|string',
            'religion' => 'required|string',
            'class' => 'required|string',
            'section' => 'required|string',
            'teacher_name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $student = DB::table('admission_forms')->where('id', $id)->first();
            
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            DB::table('admission_forms')->where('id', $id)->update([
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

            $updatedStudent = DB::table('admission_forms')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully',
                'data' => $updatedStudent
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating student',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified student
     */
    public function destroy($id)
    {
        try {
            $student = DB::table('admission_forms')->where('id', $id)->first();
            
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            DB::table('admission_forms')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting student',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get detailed student information
     */
    public function details($id)
    {
        try {
            $student = DB::table('admission_forms')->where('id', $id)->first();
            
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            // Get additional related data
            $attendance = DB::table('attendance')->where('student_id', $id)->count();
            $fees = DB::table('challans')->where('full_name', $student->full_name)->get();
            $books = DB::table('book_issues')->where('student_id', $id)->get();

            return response()->json([
                'success' => true,
                'message' => 'Student details retrieved successfully',
                'data' => [
                    'student' => $student,
                    'attendance_count' => $attendance,
                    'fees' => $fees,
                    'issued_books' => $books
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving student details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Promote student to next class
     */
    public function promote(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'new_class' => 'required|string',
            'new_section' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $student = DB::table('admission_forms')->where('id', $id)->first();
            
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            DB::table('admission_forms')->where('id', $id)->update([
                'class' => $request->new_class,
                'section' => $request->new_section,
                'updated_at' => now(),
            ]);

            $updatedStudent = DB::table('admission_forms')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Student promoted successfully',
                'data' => $updatedStudent
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error promoting student',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
