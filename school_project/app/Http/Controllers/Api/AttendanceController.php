<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    /**
     * Display a listing of attendance records
     */
    public function index(Request $request)
    {
        try {
            $query = DB::table('attendance')
                ->join('admission_forms', 'attendance.student_id', '=', 'admission_forms.id')
                ->select('attendance.*', 'admission_forms.full_name', 'admission_forms.class', 'admission_forms.section');
            
            // Filter by class
            if ($request->has('class')) {
                $query->where('admission_forms.class', $request->class);
            }
            
            // Filter by section
            if ($request->has('section')) {
                $query->where('admission_forms.section', $request->section);
            }
            
            // Filter by date
            if ($request->has('date')) {
                $query->where('attendance.date', $request->date);
            }
            
            // Filter by month
            if ($request->has('month')) {
                $query->whereMonth('attendance.date', $request->month);
            }
            
            // Filter by year
            if ($request->has('year')) {
                $query->whereYear('attendance.date', $request->year);
            }
            
            $attendance = $query->orderBy('attendance.date', 'desc')
                               ->paginate($request->get('per_page', 15));
            
            return response()->json([
                'success' => true,
                'message' => 'Attendance records retrieved successfully',
                'data' => $attendance
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving attendance records',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created attendance record
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|integer|exists:admission_forms,id',
            'date' => 'required|date',
            'status' => 'required|string|in:present,absent,late,excused',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if attendance already exists for this student and date
            $existingAttendance = DB::table('attendance')
                ->where('student_id', $request->student_id)
                ->where('date', $request->date)
                ->first();

            if ($existingAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attendance already recorded for this student on this date'
                ], 422);
            }

            $attendanceId = DB::table('attendance')->insertGetId([
                'student_id' => $request->student_id,
                'date' => $request->date,
                'status' => $request->status,
                'remarks' => $request->remarks,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $attendance = DB::table('attendance')
                ->join('admission_forms', 'attendance.student_id', '=', 'admission_forms.id')
                ->select('attendance.*', 'admission_forms.full_name', 'admission_forms.class', 'admission_forms.section')
                ->where('attendance.id', $attendanceId)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Attendance recorded successfully',
                'data' => $attendance
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error recording attendance',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified attendance record
     */
    public function show($id)
    {
        try {
            $attendance = DB::table('attendance')
                ->join('admission_forms', 'attendance.student_id', '=', 'admission_forms.id')
                ->select('attendance.*', 'admission_forms.full_name', 'admission_forms.class', 'admission_forms.section')
                ->where('attendance.id', $id)
                ->first();
            
            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attendance record not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Attendance record retrieved successfully',
                'data' => $attendance
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving attendance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified attendance record
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:present,absent,late,excused',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $attendance = DB::table('attendance')->where('id', $id)->first();
            
            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attendance record not found'
                ], 404);
            }

            DB::table('attendance')->where('id', $id)->update([
                'status' => $request->status,
                'remarks' => $request->remarks,
                'updated_at' => now(),
            ]);

            $updatedAttendance = DB::table('attendance')
                ->join('admission_forms', 'attendance.student_id', '=', 'admission_forms.id')
                ->select('attendance.*', 'admission_forms.full_name', 'admission_forms.class', 'admission_forms.section')
                ->where('attendance.id', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Attendance record updated successfully',
                'data' => $updatedAttendance
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating attendance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified attendance record
     */
    public function destroy($id)
    {
        try {
            $attendance = DB::table('attendance')->where('id', $id)->first();
            
            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attendance record not found'
                ], 404);
            }

            DB::table('attendance')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Attendance record deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting attendance record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get attendance by class and date
     */
    public function byClassAndDate($classId, $date)
    {
        try {
            $attendance = DB::table('attendance')
                ->join('admission_forms', 'attendance.student_id', '=', 'admission_forms.id')
                ->select('attendance.*', 'admission_forms.full_name', 'admission_forms.class', 'admission_forms.section')
                ->where('admission_forms.class', $classId)
                ->where('attendance.date', $date)
                ->get();

            // Get all students in the class
            $allStudents = DB::table('admission_forms')
                ->where('class', $classId)
                ->get();

            // Mark students without attendance as absent
            $attendanceData = [];
            foreach ($allStudents as $student) {
                $studentAttendance = $attendance->where('student_id', $student->id)->first();
                if ($studentAttendance) {
                    $attendanceData[] = $studentAttendance;
                } else {
                    $attendanceData[] = (object)[
                        'student_id' => $student->id,
                        'full_name' => $student->full_name,
                        'class' => $student->class,
                        'section' => $student->section,
                        'date' => $date,
                        'status' => 'not_marked',
                        'remarks' => null
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Class attendance retrieved successfully',
                'data' => [
                    'date' => $date,
                    'class' => $classId,
                    'attendance' => $attendanceData
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving class attendance',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get attendance by student and month
     */
    public function byStudentAndMonth($studentId, $month)
    {
        try {
            $student = DB::table('admission_forms')->where('id', $studentId)->first();
            
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            $attendance = DB::table('attendance')
                ->where('student_id', $studentId)
                ->whereMonth('date', $month)
                ->orderBy('date')
                ->get();

            // Calculate statistics
            $totalDays = $attendance->count();
            $presentDays = $attendance->where('status', 'present')->count();
            $absentDays = $attendance->where('status', 'absent')->count();
            $lateDays = $attendance->where('status', 'late')->count();
            $excusedDays = $attendance->where('status', 'excused')->count();

            return response()->json([
                'success' => true,
                'message' => 'Student attendance retrieved successfully',
                'data' => [
                    'student' => $student,
                    'month' => $month,
                    'attendance' => $attendance,
                    'statistics' => [
                        'total_days' => $totalDays,
                        'present_days' => $presentDays,
                        'absent_days' => $absentDays,
                        'late_days' => $lateDays,
                        'excused_days' => $excusedDays,
                        'attendance_percentage' => $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 2) : 0
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving student attendance',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk store attendance records
     */
    public function bulkStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|integer|exists:admission_forms,id',
            'attendance.*.status' => 'required|string|in:present,absent,late,excused',
            'attendance.*.remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $date = $request->date;
            $attendanceRecords = [];

            // Delete existing attendance for this date
            DB::table('attendance')->where('date', $date)->delete();

            foreach ($request->attendance as $record) {
                $attendanceRecords[] = [
                    'student_id' => $record['student_id'],
                    'date' => $date,
                    'status' => $record['status'],
                    'remarks' => $record['remarks'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('attendance')->insert($attendanceRecords);

            return response()->json([
                'success' => true,
                'message' => 'Bulk attendance recorded successfully',
                'data' => [
                    'date' => $date,
                    'records_count' => count($attendanceRecords)
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error recording bulk attendance',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
