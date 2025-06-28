<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDF;

class ChallanController extends Controller
{
    /**
     * Display a listing of challans
     */
    public function index(Request $request)
    {
        try {
            $query = DB::table('challans');
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('full_name', 'LIKE', "%{$search}%")
                      ->orWhere('father_name', 'LIKE', "%{$search}%")
                      ->orWhere('gr_number', 'LIKE', "%{$search}%")
                      ->orWhere('class', 'LIKE', "%{$search}%");
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
            
            // Filter by status
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
            
            // Filter by month/year
            if ($request->has('month')) {
                $query->where('from_month', $request->month);
            }
            
            if ($request->has('year')) {
                $query->where('from_year', $request->year);
            }
            
            $challans = $query->orderBy('created_at', 'desc')
                             ->paginate($request->get('per_page', 15));
            
            return response()->json([
                'success' => true,
                'message' => 'Challans retrieved successfully',
                'data' => $challans
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving challans',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created challan
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_name' => 'required|string|max:255',
            'class' => 'required|string',
            'section' => 'required|string',
            'full_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'gr_number' => 'nullable|string',
            'academic_year' => 'required|string',
            'year' => 'required|integer',
            'from_month' => 'required|string',
            'from_year' => 'required|integer',
            'to_month' => 'nullable|string',
            'to_year' => 'nullable|integer',
            'total_fee' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'amount_in_words' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $challanId = DB::table('challans')->insertGetId([
                'school_name' => $request->school_name,
                'class' => $request->class,
                'section' => $request->section,
                'full_name' => $request->full_name,
                'father_name' => $request->father_name,
                'gr_number' => $request->gr_number,
                'academic_year' => $request->academic_year,
                'year' => $request->year,
                'from_month' => $request->from_month,
                'from_year' => $request->from_year,
                'to_month' => $request->to_month,
                'to_year' => $request->to_year,
                'total_fee' => $request->total_fee,
                'status' => 'unpaid',
                'due_date' => $request->due_date,
                'amount_in_words' => $request->amount_in_words,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $challan = DB::table('challans')->where('id', $challanId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Challan created successfully',
                'data' => $challan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating challan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified challan
     */
    public function show($id)
    {
        try {
            $challan = DB::table('challans')->where('id', $id)->first();
            
            if (!$challan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Challan not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Challan retrieved successfully',
                'data' => $challan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving challan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified challan
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'school_name' => 'required|string|max:255',
            'class' => 'required|string',
            'section' => 'required|string',
            'full_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'gr_number' => 'nullable|string',
            'academic_year' => 'required|string',
            'year' => 'required|integer',
            'from_month' => 'required|string',
            'from_year' => 'required|integer',
            'to_month' => 'nullable|string',
            'to_year' => 'nullable|integer',
            'total_fee' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'amount_in_words' => 'required|string',
            'status' => 'required|string|in:paid,unpaid,overdue',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $challan = DB::table('challans')->where('id', $id)->first();
            
            if (!$challan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Challan not found'
                ], 404);
            }

            DB::table('challans')->where('id', $id)->update([
                'school_name' => $request->school_name,
                'class' => $request->class,
                'section' => $request->section,
                'full_name' => $request->full_name,
                'father_name' => $request->father_name,
                'gr_number' => $request->gr_number,
                'academic_year' => $request->academic_year,
                'year' => $request->year,
                'from_month' => $request->from_month,
                'from_year' => $request->from_year,
                'to_month' => $request->to_month,
                'to_year' => $request->to_year,
                'total_fee' => $request->total_fee,
                'status' => $request->status,
                'due_date' => $request->due_date,
                'amount_in_words' => $request->amount_in_words,
                'updated_at' => now(),
            ]);

            $updatedChallan = DB::table('challans')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Challan updated successfully',
                'data' => $updatedChallan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating challan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified challan
     */
    public function destroy($id)
    {
        try {
            $challan = DB::table('challans')->where('id', $id)->first();
            
            if (!$challan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Challan not found'
                ], 404);
            }

            DB::table('challans')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Challan deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting challan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download challan as PDF
     */
    public function downloadPdf($id)
    {
        try {
            $challan = DB::table('challans')->where('id', $id)->first();
            
            if (!$challan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Challan not found'
                ], 404);
            }

            // Generate PDF (you'll need to install dompdf or similar)
            $pdf = PDF::loadView('pdf.challan', compact('challan'));
            
            return $pdf->download('challan_' . $id . '.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating PDF',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark challan as paid
     */
    public function markPaid(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
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
            $challan = DB::table('challans')->where('id', $id)->first();
            
            if (!$challan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Challan not found'
                ], 404);
            }

            DB::table('challans')->where('id', $id)->update([
                'status' => 'paid',
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'remarks' => $request->remarks,
                'updated_at' => now(),
            ]);

            $updatedChallan = DB::table('challans')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Challan marked as paid successfully',
                'data' => $updatedChallan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error marking challan as paid',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get challans by student
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

            $challans = DB::table('challans')
                ->where('full_name', $student->full_name)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Student challans retrieved successfully',
                'data' => [
                    'student' => $student,
                    'challans' => $challans
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving student challans',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get challans by class
     */
    public function byClass($classId)
    {
        try {
            $challans = DB::table('challans')
                ->where('class', $classId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Class challans retrieved successfully',
                'data' => $challans
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving class challans',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
