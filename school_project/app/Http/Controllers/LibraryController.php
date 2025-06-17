<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    // Book Actions (for addbook.blade.php)
    public function addBook()
    {
        $books = DB::table('books')->get();
        return view('library.addbook', compact('books'));
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'genre' => 'required|string|max:100',
            'publication_year' => 'required|numeric|min:1900|max:' . date('Y'),
            'library_id' => 'required|string|max:50|unique:books,library_id',
            'entry_date' => 'required|date',
        ]);

        DB::table('books')->insert([
            'name' => $request->name,
            'author' => $request->author,
            'category' => $request->category,
            'genre' => $request->genre,
            'publication_year' => $request->publication_year,
            'library_id' => $request->library_id,
            'entry_date' => $request->entry_date,
            'is_issued' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Book added successfully!');
    }

    public function editBook($id)
    {
        $book = DB::table('books')->where('id', $id)->first();
        $books = DB::table('books')->get();
        if (!$book) {
            return redirect()->route('add-book')->with('error', 'Book not found.');
        }
        return view('library.addbook', compact('book', 'books'));
    }

    public function updateBook(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'genre' => 'required|string|max:100',
            'publication_year' => 'required|numeric|min:1900|max:' . date('Y'),
            'library_id' => 'required|string|max:50|unique:books,library_id,' . $id,
            'entry_date' => 'required|date',
        ]);

        $updated = DB::table('books')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'author' => $request->author,
                'category' => $request->category,
                'genre' => $request->genre,
                'publication_year' => $request->publication_year,
                'library_id' => $request->library_id,
                'entry_date' => $request->entry_date,
                'updated_at' => now(),
            ]);

        if ($updated) {
            return redirect()->route('add-book')->with('success', 'Book updated successfully!');
        }
        return redirect()->route('add-book')->with('error', 'Book not found or no changes made.');
    }

    public function deleteBook($id)
    {
        $deleted = DB::table('books')->where('id', $id)->delete();
        if ($deleted) {
            return redirect()->route('add-book')->with('success', 'Book deleted successfully!');
        }
        return redirect()->route('add-book')->with('error', 'Book not found.');
    }

    // Book Issue Actions (for issuebook.blade.php)
    public function issueBook()
    {
        $books = DB::table('books')->where('is_issued', false)->get();
        $issues = DB::table('book_issues')
            ->join('books', 'book_issues.book_id', '=', 'books.id')
            ->select('book_issues.*', 'books.library_id', 'books.name', 'books.author', 'books.category', 'books.genre')
            ->get();
        return view('library.issuebook', compact('books', 'issues'));
    }

    public function storeIssue(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'lender_name' => 'required|string|max:255',
            'lender_designation' => 'required|in:Student,Teacher,Admin Staff',
            'lender_class' => 'required_if:lender_designation,Student|string|max:50|nullable',
            'lender_section' => 'required_if:lender_designation,Student|string|max:50|nullable',
            'lender_roll_number' => 'required_if:lender_designation,Student|string|max:50|nullable',
            'issuance_date' => 'required|date',
            'tentative_return_date' => 'required|date|after:issuance_date',
        ]);

        DB::beginTransaction();
        try {
            DB::table('books')->where('id', $request->book_id)->update(['is_issued' => true]);
            DB::table('book_issues')->insert([
                'book_id' => $request->book_id,
                'lender_name' => $request->lender_name,
                'lender_designation' => $request->lender_designation,
                'lender_class' => $request->lender_class,
                'lender_section' => $request->lender_section,
                'lender_roll_number' => $request->lender_roll_number,
                'issuance_date' => $request->issuance_date,
                'tentative_return_date' => $request->tentative_return_date,
                'status' => 'issued',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Book issued successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to issue book.');
        }
    }

    public function updateIssue(Request $request, $id)
    {
        $request->validate([
            'issuance_date' => 'required|date',
            'return_date' => 'nullable|date|after:issuance_date',
        ]);

        $issue = DB::table('book_issues')->where('id', $id)->first();
        if (!$issue) {
            return redirect()->route('issue-book')->with('error', 'Issue record not found.');
        }

        $updates = [
            'issuance_date' => $request->issuance_date,
            'updated_at' => now(),
        ];

        if ($request->return_date) {
            $updates['return_date'] = $request->return_date;
            $updates['status'] = 'returned';
            DB::table('books')->where('id', $issue->book_id)->update(['is_issued' => false]);
        }

        $updated = DB::table('book_issues')->where('id', $id)->update($updates);

        if ($updated) {
            return redirect()->route('issue-book')->with('success', 'Issue record updated successfully!');
        }
        return redirect()->back()->with('error', 'No changes made.');
    }
}