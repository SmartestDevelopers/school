<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    /**
     * Display a listing of classes
     */
    public function index(Request $request)
    {
        try {
            $query = DB::table('class_forms');
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('class_name', 'LIKE', "%{$search}%")
                      ->orWhere('section', 'LIKE', "%{$search}%")
                      ->orWhere('teacher_name', 'LIKE', "%{$search}%");
                });
            }
            
            $classes = $query->paginate($request->get('per_page', 15));
            
            return response()->json([
                'success' => true,
                'message' => 'Classes retrieved successfully',
                'data' => $classes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving classes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created class
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_name' => 'required|string|max:255',
            'section' => 'required|string|max:10',
            'teacher_name' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:50',
            'capacity' => 'nullable|integer|min:1',
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
            $classId = DB::table('class_forms')->insertGetId([
                'class_name' => $request->class_name,
                'section' => $request->section,
                'teacher_name' => $request->teacher_name,
                'room_number' => $request->room_number,
                'capacity' => $request->capacity,
                'description' => $request->description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $class = DB::table('class_forms')->where('id', $classId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Class created successfully',
                'data' => $class
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating class',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified class
     */
    public function show($id)
    {
        try {
            $class = DB::table('class_forms')->where('id', $id)->first();
            
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Class not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Class retrieved successfully',
                'data' => $class
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving class',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified class
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'class_name' => 'required|string|max:255',
            'section' => 'required|string|max:10',
            'teacher_name' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:50',
            'capacity' => 'nullable|integer|min:1',
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
            $class = DB::table('class_forms')->where('id', $id)->first();
            
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Class not found'
                ], 404);
            }

            DB::table('class_forms')->where('id', $id)->update([
                'class_name' => $request->class_name,
                'section' => $request->section,
                'teacher_name' => $request->teacher_name,
                'room_number' => $request->room_number,
                'capacity' => $request->capacity,
                'description' => $request->description,
                'updated_at' => now(),
            ]);

            $updatedClass = DB::table('class_forms')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Class updated successfully',
                'data' => $updatedClass
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating class',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified class
     */
    public function destroy($id)
    {
        try {
            $class = DB::table('class_forms')->where('id', $id)->first();
            
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Class not found'
                ], 404);
            }

            DB::table('class_forms')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Class deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting class',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get students in the specified class
     */
    public function students($id)
    {
        try {
            $class = DB::table('class_forms')->where('id', $id)->first();
            
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Class not found'
                ], 404);
            }

            $students = DB::table('admission_forms')
                ->where('class', $class->class_name)
                ->where('section', $class->section)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Students retrieved successfully',
                'data' => [
                    'class' => $class,
                    'students' => $students,
                    'student_count' => $students->count()
                ]
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
     * Get subjects for the specified class
     */
    public function subjects($id)
    {
        try {
            $class = DB::table('class_forms')->where('id', $id)->first();
            
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Class not found'
                ], 404);
            }

            $subjects = DB::table('subjects')
                ->where('class', $class->class_name)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Subjects retrieved successfully',
                'data' => [
                    'class' => $class,
                    'subjects' => $subjects
                ]
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
     * Get class routine
     */
    public function routine($id)
    {
        try {
            $class = DB::table('class_forms')->where('id', $id)->first();
            
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Class not found'
                ], 404);
            }

            // Assuming there's a class_routines table
            $routine = DB::table('class_routines')
                ->where('class_id', $id)
                ->orderBy('day_of_week')
                ->orderBy('start_time')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Class routine retrieved successfully',
                'data' => [
                    'class' => $class,
                    'routine' => $routine
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving class routine',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store class routine
     */
    public function storeRoutine(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'routines' => 'required|array',
            'routines.*.day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'routines.*.subject' => 'required|string',
            'routines.*.teacher' => 'required|string',
            'routines.*.start_time' => 'required|date_format:H:i',
            'routines.*.end_time' => 'required|date_format:H:i|after:routines.*.start_time',
            'routines.*.room' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $class = DB::table('class_forms')->where('id', $id)->first();
            
            if (!$class) {
                return response()->json([
                    'success' => false,
                    'message' => 'Class not found'
                ], 404);
            }

            // Delete existing routines for this class
            DB::table('class_routines')->where('class_id', $id)->delete();

            // Insert new routines
            foreach ($request->routines as $routine) {
                DB::table('class_routines')->insert([
                    'class_id' => $id,
                    'day_of_week' => $routine['day_of_week'],
                    'subject' => $routine['subject'],
                    'teacher' => $routine['teacher'],
                    'start_time' => $routine['start_time'],
                    'end_time' => $routine['end_time'],
                    'room' => $routine['room'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $newRoutine = DB::table('class_routines')
                ->where('class_id', $id)
                ->orderBy('day_of_week')
                ->orderBy('start_time')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Class routine created successfully',
                'data' => $newRoutine
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating class routine',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
