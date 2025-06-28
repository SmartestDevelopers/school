<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FeeController extends Controller
{
    /**
     * Display a listing of fees
     */
    public function index(Request $request)
    {
        try {
            $query = DB::table('fees');
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('fee_name', 'LIKE', "%{$search}%")
                      ->orWhere('class', 'LIKE', "%{$search}%")
                      ->orWhere('section', 'LIKE', "%{$search}%");
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
            
            $fees = $query->paginate($request->get('per_page', 15));
            
            return response()->json([
                'success' => true,
                'message' => 'Fees retrieved successfully',
                'data' => $fees
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving fees',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created fee
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fee_name' => 'required|string|max:255',
            'fee_type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'class' => 'required|string',
            'section' => 'required|string',
            'due_date' => 'required|date',
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
            $feeId = DB::table('fees')->insertGetId([
                'fee_name' => $request->fee_name,
                'fee_type' => $request->fee_type,
                'amount' => $request->amount,
                'class' => $request->class,
                'section' => $request->section,
                'due_date' => $request->due_date,
                'description' => $request->description,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $fee = DB::table('fees')->where('id', $feeId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Fee created successfully',
                'data' => $fee
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating fee',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified fee
     */
    public function show($id)
    {
        try {
            $fee = DB::table('fees')->where('id', $id)->first();
            
            if (!$fee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fee not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Fee retrieved successfully',
                'data' => $fee
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving fee',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified fee
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fee_name' => 'required|string|max:255',
            'fee_type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'class' => 'required|string',
            'section' => 'required|string',
            'due_date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $fee = DB::table('fees')->where('id', $id)->first();
            
            if (!$fee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fee not found'
                ], 404);
            }

            DB::table('fees')->where('id', $id)->update([
                'fee_name' => $request->fee_name,
                'fee_type' => $request->fee_type,
                'amount' => $request->amount,
                'class' => $request->class,
                'section' => $request->section,
                'due_date' => $request->due_date,
                'description' => $request->description,
                'status' => $request->status,
                'updated_at' => now(),
            ]);

            $updatedFee = DB::table('fees')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Fee updated successfully',
                'data' => $updatedFee
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating fee',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified fee
     */
    public function destroy($id)
    {
        try {
            $fee = DB::table('fees')->where('id', $id)->first();
            
            if (!$fee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fee not found'
                ], 404);
            }

            DB::table('fees')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Fee deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting fee',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get fees by class
     */
    public function byClass($classId)
    {
        try {
            $fees = DB::table('fees')
                ->where('class', $classId)
                ->where('status', 'active')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Class fees retrieved successfully',
                'data' => $fees
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving class fees',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get fees by student
     */
    public function byStudent($studentId)
    {
        try {
            $student = DB::table('admission_forms')->where('id', $studentId)->first();
            
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            $fees = DB::table('fees')
                ->where('class', $student->class)
                ->where('section', $student->section)
                ->where('status', 'active')
                ->get();

            // Get payment history for this student
            $payments = DB::table('challans')
                ->where('full_name', $student->full_name)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Student fees retrieved successfully',
                'data' => [
                    'student' => $student,
                    'applicable_fees' => $fees,
                    'payment_history' => $payments
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving student fees',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
