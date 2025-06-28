<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    /**
     * Display a listing of subjects
     */
    public function index(Request $request)
    {
        try {
            $query = DB::table('subjects');
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('subject_name', 'LIKE', "%{$search}%")
                      ->orWhere('subject_type', 'LIKE', "%{$search}%")
                      ->orWhere('class', 'LIKE', "%{$search}%");
                });
            }
            
            // Filter by class
            if ($request->has('class')) {
                $query->where('class', $request->class);
            }
            
            // Filter by subject type
            if ($request->has('type')) {
                $query->where('subject_type', $request->type);
            }
            
            $subjects = $query->paginate($request->get('per_page', 15));
            
            return response()->json([
                'success' => true,
                'message' => 'Subjects retrieved successfully',
                'data' => $subjects
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving subjects',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created subject
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_name' => 'required|string|max:255',
            'subject_type' => 'required|string',
            'class' => 'required|string',
            'subject_code' => 'nullable|string|unique:subjects,subject_code',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|integer|exists:teachers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $subjectId = DB::table('subjects')->insertGetId([
                'subject_name' => $request->subject_name,
                'subject_type' => $request->subject_type,
                'class' => $request->class,
                'subject_code' => $request->subject_code,
                'description' => $request->description,
                'teacher_id' => $request->teacher_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $subject = DB::table('subjects')->where('id', $subjectId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Subject created successfully',
                'data' => $subject
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating subject',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified subject
     */
    public function show($id)
    {
        try {
            $subject = DB::table('subjects')
                ->leftJoin('teachers', 'subjects.teacher_id', '=', 'teachers.id')
                ->select('subjects.*', 'teachers.first_name', 'teachers.last_name')
                ->where('subjects.id', $id)
                ->first();
            
            if (!$subject) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subject not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Subject retrieved successfully',
                'data' => $subject
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving subject',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified subject
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'subject_name' => 'required|string|max:255',
            'subject_type' => 'required|string',
            'class' => 'required|string',
            'subject_code' => 'nullable|string|unique:subjects,subject_code,' . $id,
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|integer|exists:teachers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $subject = DB::table('subjects')->where('id', $id)->first();
            
            if (!$subject) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subject not found'
                ], 404);
            }

            DB::table('subjects')->where('id', $id)->update([
                'subject_name' => $request->subject_name,
                'subject_type' => $request->subject_type,
                'class' => $request->class,
                'subject_code' => $request->subject_code,
                'description' => $request->description,
                'teacher_id' => $request->teacher_id,
                'updated_at' => now(),
            ]);

            $updatedSubject = DB::table('subjects')
                ->leftJoin('teachers', 'subjects.teacher_id', '=', 'teachers.id')
                ->select('subjects.*', 'teachers.first_name', 'teachers.last_name')
                ->where('subjects.id', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Subject updated successfully',
                'data' => $updatedSubject
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating subject',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified subject
     */
    public function destroy($id)
    {
        try {
            $subject = DB::table('subjects')->where('id', $id)->first();
            
            if (!$subject) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subject not found'
                ], 404);
            }

            DB::table('subjects')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Subject deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting subject',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get classes for the specified subject
     */
    public function classes($id)
    {
        try {
            $subject = DB::table('subjects')->where('id', $id)->first();
            
            if (!$subject) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subject not found'
                ], 404);
            }

            $classes = DB::table('class_forms')
                ->where('class_name', $subject->class)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Subject classes retrieved successfully',
                'data' => [
                    'subject' => $subject,
                    'classes' => $classes
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving subject classes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get teachers for the specified subject
     */
    public function teachers($id)
    {
        try {
            $subject = DB::table('subjects')->where('id', $id)->first();
            
            if (!$subject) {
                return response()->json([
                    'success' => false,
                    'message' => 'Subject not found'
                ], 404);
            }

            $teachers = DB::table('teachers')
                ->where('subject', $subject->subject_name)
                ->orWhere('id', $subject->teacher_id)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Subject teachers retrieved successfully',
                'data' => [
                    'subject' => $subject,
                    'teachers' => $teachers
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving subject teachers',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
