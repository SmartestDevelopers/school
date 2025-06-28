<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookIssueController extends Controller
{
    /**
     * Display a listing of book issues
     */
    public function index(Request $request)
    {
        try {
            $query = DB::table('book_issues')
                ->join('books', 'book_issues.book_id', '=', 'books.id')
                ->join('admission_forms', 'book_issues.student_id', '=', 'admission_forms.id')
                ->select(
                    'book_issues.*',
                    'books.title as book_title',
                    'books.author as book_author',
                    'books.isbn',
                    'admission_forms.full_name as student_name',
                    'admission_forms.class',
                    'admission_forms.section'
                );
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('books.title', 'LIKE', "%{$search}%")
                      ->orWhere('books.author', 'LIKE', "%{$search}%")
                      ->orWhere('admission_forms.full_name', 'LIKE', "%{$search}%")
                      ->orWhere('books.isbn', 'LIKE', "%{$search}%");
                });
            }
            
            // Filter by status
            if ($request->has('status')) {
                if ($request->status == 'issued') {
                    $query->whereNull('book_issues.return_date');
                } elseif ($request->status == 'returned') {
                    $query->whereNotNull('book_issues.return_date');
                } elseif ($request->status == 'overdue') {
                    $query->whereNull('book_issues.return_date')
                          ->where('book_issues.due_date', '<', now());
                }
            }
            
            // Filter by class
            if ($request->has('class')) {
                $query->where('admission_forms.class', $request->class);
            }
            
            $bookIssues = $query->orderBy('book_issues.issue_date', 'desc')
                               ->paginate($request->get('per_page', 15));
            
            return response()->json([
                'success' => true,
                'message' => 'Book issues retrieved successfully',
                'data' => $bookIssues
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving book issues',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created book issue
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|integer|exists:books,id',
            'student_id' => 'required|integer|exists:admission_forms,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
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
            // Check if book is available
            $book = DB::table('books')->where('id', $request->book_id)->first();
            
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found'
                ], 404);
            }

            if ($book->available_copies <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book is not available for issue'
                ], 422);
            }

            // Check if student already has this book issued
            $existingIssue = DB::table('book_issues')
                ->where('book_id', $request->book_id)
                ->where('student_id', $request->student_id)
                ->whereNull('return_date')
                ->first();

            if ($existingIssue) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student already has this book issued'
                ], 422);
            }

            // Check student's book limit (assuming max 3 books per student)
            $studentIssueCount = DB::table('book_issues')
                ->where('student_id', $request->student_id)
                ->whereNull('return_date')
                ->count();

            if ($studentIssueCount >= 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student has reached maximum book issue limit'
                ], 422);
            }

            DB::beginTransaction();

            // Create book issue record
            $issueId = DB::table('book_issues')->insertGetId([
                'book_id' => $request->book_id,
                'student_id' => $request->student_id,
                'issue_date' => $request->issue_date,
                'due_date' => $request->due_date,
                'remarks' => $request->remarks,
                'status' => 'issued',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update book available copies
            DB::table('books')->where('id', $request->book_id)->decrement('available_copies');

            DB::commit();

            $bookIssue = DB::table('book_issues')
                ->join('books', 'book_issues.book_id', '=', 'books.id')
                ->join('admission_forms', 'book_issues.student_id', '=', 'admission_forms.id')
                ->select(
                    'book_issues.*',
                    'books.title as book_title',
                    'books.author as book_author',
                    'admission_forms.full_name as student_name'
                )
                ->where('book_issues.id', $issueId)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Book issued successfully',
                'data' => $bookIssue
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error issuing book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified book issue
     */
    public function show($id)
    {
        try {
            $bookIssue = DB::table('book_issues')
                ->join('books', 'book_issues.book_id', '=', 'books.id')
                ->join('admission_forms', 'book_issues.student_id', '=', 'admission_forms.id')
                ->select(
                    'book_issues.*',
                    'books.title as book_title',
                    'books.author as book_author',
                    'books.isbn',
                    'admission_forms.full_name as student_name',
                    'admission_forms.class',
                    'admission_forms.section'
                )
                ->where('book_issues.id', $id)
                ->first();
            
            if (!$bookIssue) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book issue record not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Book issue retrieved successfully',
                'data' => $bookIssue
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving book issue',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified book issue
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'due_date' => 'required|date',
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
            $bookIssue = DB::table('book_issues')->where('id', $id)->first();
            
            if (!$bookIssue) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book issue record not found'
                ], 404);
            }

            if ($bookIssue->return_date) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot update returned book issue'
                ], 422);
            }

            DB::table('book_issues')->where('id', $id)->update([
                'due_date' => $request->due_date,
                'remarks' => $request->remarks,
                'updated_at' => now(),
            ]);

            $updatedBookIssue = DB::table('book_issues')
                ->join('books', 'book_issues.book_id', '=', 'books.id')
                ->join('admission_forms', 'book_issues.student_id', '=', 'admission_forms.id')
                ->select(
                    'book_issues.*',
                    'books.title as book_title',
                    'books.author as book_author',
                    'admission_forms.full_name as student_name'
                )
                ->where('book_issues.id', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Book issue updated successfully',
                'data' => $updatedBookIssue
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating book issue',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified book issue
     */
    public function destroy($id)
    {
        try {
            $bookIssue = DB::table('book_issues')->where('id', $id)->first();
            
            if (!$bookIssue) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book issue record not found'
                ], 404);
            }

            DB::beginTransaction();

            // If book is not returned, increment available copies
            if (!$bookIssue->return_date) {
                DB::table('books')->where('id', $bookIssue->book_id)->increment('available_copies');
            }

            DB::table('book_issues')->where('id', $id)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Book issue record deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting book issue record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get book issues by student
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

            $bookIssues = DB::table('book_issues')
                ->join('books', 'book_issues.book_id', '=', 'books.id')
                ->select(
                    'book_issues.*',
                    'books.title as book_title',
                    'books.author as book_author',
                    'books.isbn'
                )
                ->where('book_issues.student_id', $studentId)
                ->orderBy('book_issues.issue_date', 'desc')
                ->get();

            // Separate current and returned books
            $currentIssues = $bookIssues->whereNull('return_date');
            $returnedBooks = $bookIssues->whereNotNull('return_date');

            return response()->json([
                'success' => true,
                'message' => 'Student book issues retrieved successfully',
                'data' => [
                    'student' => $student,
                    'current_issues' => $currentIssues->values(),
                    'returned_books' => $returnedBooks->values(),
                    'current_count' => $currentIssues->count(),
                    'total_issued' => $bookIssues->count()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving student book issues',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Return a book
     */
    public function returnBook(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'return_date' => 'required|date',
            'condition' => 'required|string|in:good,damaged,lost',
            'fine_amount' => 'nullable|numeric|min:0',
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
            $bookIssue = DB::table('book_issues')->where('id', $id)->first();
            
            if (!$bookIssue) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book issue record not found'
                ], 404);
            }

            if ($bookIssue->return_date) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book already returned'
                ], 422);
            }

            DB::beginTransaction();

            // Update book issue record
            DB::table('book_issues')->where('id', $id)->update([
                'return_date' => $request->return_date,
                'condition' => $request->condition,
                'fine_amount' => $request->fine_amount ?? 0,
                'remarks' => $request->remarks,
                'status' => 'returned',
                'updated_at' => now(),
            ]);

            // Increment available copies if book is not lost
            if ($request->condition !== 'lost') {
                DB::table('books')->where('id', $bookIssue->book_id)->increment('available_copies');
            }

            DB::commit();

            $updatedBookIssue = DB::table('book_issues')
                ->join('books', 'book_issues.book_id', '=', 'books.id')
                ->join('admission_forms', 'book_issues.student_id', '=', 'admission_forms.id')
                ->select(
                    'book_issues.*',
                    'books.title as book_title',
                    'books.author as book_author',
                    'admission_forms.full_name as student_name'
                )
                ->where('book_issues.id', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Book returned successfully',
                'data' => $updatedBookIssue
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error returning book',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
