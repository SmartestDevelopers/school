<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of books
     */
    public function index(Request $request)
    {
        try {
            $query = DB::table('books');
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('author', 'LIKE', "%{$search}%")
                      ->orWhere('isbn', 'LIKE', "%{$search}%")
                      ->orWhere('category', 'LIKE', "%{$search}%");
                });
            }
            
            // Filter by category
            if ($request->has('category')) {
                $query->where('category', $request->category);
            }
            
            // Filter by availability
            if ($request->has('available')) {
                if ($request->available == 'true') {
                    $query->where('available_copies', '>', 0);
                } else {
                    $query->where('available_copies', '=', 0);
                }
            }
            
            $books = $query->paginate($request->get('per_page', 15));
            
            return response()->json([
                'success' => true,
                'message' => 'Books retrieved successfully',
                'data' => $books
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving books',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created book
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'category' => 'required|string',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $coverImagePath = null;
            if ($request->hasFile('cover_image')) {
                $coverImagePath = $request->file('cover_image')->store('book_covers', 'public');
            }

            $bookId = DB::table('books')->insertGetId([
                'title' => $request->title,
                'author' => $request->author,
                'isbn' => $request->isbn,
                'category' => $request->category,
                'publisher' => $request->publisher,
                'publication_year' => $request->publication_year,
                'total_copies' => $request->total_copies,
                'available_copies' => $request->available_copies,
                'price' => $request->price,
                'description' => $request->description,
                'cover_image' => $coverImagePath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $book = DB::table('books')->where('id', $bookId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Book created successfully',
                'data' => $book
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified book
     */
    public function show($id)
    {
        try {
            $book = DB::table('books')->where('id', $id)->first();
            
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found'
                ], 404);
            }

            // Get issue history for this book
            $issueHistory = DB::table('book_issues')
                ->join('admission_forms', 'book_issues.student_id', '=', 'admission_forms.id')
                ->select('book_issues.*', 'admission_forms.full_name as student_name')
                ->where('book_issues.book_id', $id)
                ->orderBy('book_issues.issue_date', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Book retrieved successfully',
                'data' => [
                    'book' => $book,
                    'issue_history' => $issueHistory
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified book
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $id,
            'category' => 'required|string',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
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
            $book = DB::table('books')->where('id', $id)->first();
            
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found'
                ], 404);
            }

            DB::table('books')->where('id', $id)->update([
                'title' => $request->title,
                'author' => $request->author,
                'isbn' => $request->isbn,
                'category' => $request->category,
                'publisher' => $request->publisher,
                'publication_year' => $request->publication_year,
                'total_copies' => $request->total_copies,
                'available_copies' => $request->available_copies,
                'price' => $request->price,
                'description' => $request->description,
                'updated_at' => now(),
            ]);

            $updatedBook = DB::table('books')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Book updated successfully',
                'data' => $updatedBook
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified book
     */
    public function destroy($id)
    {
        try {
            $book = DB::table('books')->where('id', $id)->first();
            
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found'
                ], 404);
            }

            // Check if book has any pending issues
            $pendingIssues = DB::table('book_issues')
                ->where('book_id', $id)
                ->whereNull('return_date')
                ->count();

            if ($pendingIssues > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete book with pending issues'
                ], 422);
            }

            DB::table('books')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Book deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available books
     */
    public function available(Request $request)
    {
        try {
            $query = DB::table('books')->where('available_copies', '>', 0);
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('author', 'LIKE', "%{$search}%")
                      ->orWhere('category', 'LIKE', "%{$search}%");
                });
            }
            
            // Filter by category
            if ($request->has('category')) {
                $query->where('category', $request->category);
            }
            
            $books = $query->paginate($request->get('per_page', 15));
            
            return response()->json([
                'success' => true,
                'message' => 'Available books retrieved successfully',
                'data' => $books
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving available books',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
