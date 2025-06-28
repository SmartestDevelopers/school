<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers
     */
    public function index(Request $request)
    {
        try {
            $query = DB::table('teachers');
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%{$search}%")
                      ->orWhere('last_name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%");
                });
            }
            
            // Filter by subject
            if ($request->has('subject')) {
                $query->where('subject', $request->subject);
            }
            
            // Filter by class
            if ($request->has('class')) {
                $query->where('class', $request->class);
            }
            
            $teachers = $query->paginate($request->get('per_page', 15));
            
            return response()->json([
                'success' => true,
                'message' => 'Teachers retrieved successfully',
                'data' => $teachers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving teachers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created teacher
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date',
            'blood_group' => 'required|string',
            'religion' => 'required|string',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|string',
            'subject' => 'nullable|string',
            'class' => 'nullable|string',
            'section' => 'nullable|string',
            'salary' => 'nullable|numeric',
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
                $photoPath = $request->file('photo')->store('teacher_photos', 'public');
            }

            $teacherId = DB::table('teachers')->insertGetId([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'blood_group' => $request->blood_group,
                'religion' => $request->religion,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'qualification' => $request->qualification,
                'experience' => $request->experience,
                'subject' => $request->subject,
                'class' => $request->class,
                'section' => $request->section,
                'salary' => $request->salary,
                'photo' => $photoPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $teacher = DB::table('teachers')->where('id', $teacherId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Teacher created successfully',
                'data' => $teacher
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating teacher',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified teacher
     */
    public function show($id)
    {
        try {
            $teacher = DB::table('teachers')->where('id', $id)->first();
            
            if (!$teacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Teacher retrieved successfully',
                'data' => $teacher
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving teacher',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified teacher
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date',
            'blood_group' => 'required|string',
            'religion' => 'required|string',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'phone' => 'required|string',
            'address' => 'required|string',
            'qualification' => 'nullable|string',
            'experience' => 'nullable|string',
            'subject' => 'nullable|string',
            'class' => 'nullable|string',
            'section' => 'nullable|string',
            'salary' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $teacher = DB::table('teachers')->where('id', $id)->first();
            
            if (!$teacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher not found'
                ], 404);
            }

            DB::table('teachers')->where('id', $id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'blood_group' => $request->blood_group,
                'religion' => $request->religion,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'qualification' => $request->qualification,
                'experience' => $request->experience,
                'subject' => $request->subject,
                'class' => $request->class,
                'section' => $request->section,
                'salary' => $request->salary,
                'updated_at' => now(),
            ]);

            $updatedTeacher = DB::table('teachers')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Teacher updated successfully',
                'data' => $updatedTeacher
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating teacher',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified teacher
     */
    public function destroy($id)
    {
        try {
            $teacher = DB::table('teachers')->where('id', $id)->first();
            
            if (!$teacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher not found'
                ], 404);
            }

            DB::table('teachers')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Teacher deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting teacher',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get detailed teacher information
     */
    public function details($id)
    {
        try {
            $teacher = DB::table('teachers')->where('id', $id)->first();
            
            if (!$teacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher not found'
                ], 404);
            }

            // Get additional related data
            $students = DB::table('admission_forms')
                ->where('teacher_name', $teacher->first_name . ' ' . $teacher->last_name)
                ->count();
            
            $subjects = DB::table('subjects')
                ->where('teacher_id', $id)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Teacher details retrieved successfully',
                'data' => [
                    'teacher' => $teacher,
                    'student_count' => $students,
                    'subjects' => $subjects
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving teacher details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get teacher payment history
     */
    public function payments($id)
    {
        try {
            $teacher = DB::table('teachers')->where('id', $id)->first();
            
            if (!$teacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher not found'
                ], 404);
            }

            // Assuming there's a teacher_payments table
            $payments = DB::table('teacher_payments')
                ->where('teacher_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Teacher payments retrieved successfully',
                'data' => $payments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving teacher payments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add payment for teacher
     */
    public function addPayment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $teacher = DB::table('teachers')->where('id', $id)->first();
            
            if (!$teacher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher not found'
                ], 404);
            }

            $paymentId = DB::table('teacher_payments')->insertGetId([
                'teacher_id' => $id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'description' => $request->description,
                'status' => 'paid',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $payment = DB::table('teacher_payments')->where('id', $paymentId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Payment added successfully',
                'data' => $payment
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding payment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
