<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function stats()
    {
        try {
            // Student statistics
            $totalStudents = DB::table('admission_forms')->count();
            $studentsByClass = DB::table('admission_forms')
                ->select('class', DB::raw('count(*) as count'))
                ->groupBy('class')
                ->get();

            // Teacher statistics
            $totalTeachers = DB::table('teachers')->count();
            $teachersBySubject = DB::table('teachers')
                ->select('subject', DB::raw('count(*) as count'))
                ->whereNotNull('subject')
                ->groupBy('subject')
                ->get();

            // Parent statistics
            $totalParents = DB::table('parents')->count();

            // Fee statistics
            $totalFees = DB::table('challans')->sum('total_fee');
            $paidFees = DB::table('challans')->where('status', 'paid')->sum('total_fee');
            $unpaidFees = DB::table('challans')->where('status', 'unpaid')->sum('total_fee');
            $overdueChallans = DB::table('challans')
                ->where('status', 'unpaid')
                ->where('due_date', '<', now())
                ->count();

            // Library statistics
            $totalBooks = DB::table('books')->sum('total_copies');
            $availableBooks = DB::table('books')->sum('available_copies');
            $issuedBooks = $totalBooks - $availableBooks;
            $overdueBooks = DB::table('book_issues')
                ->whereNull('return_date')
                ->where('due_date', '<', now())
                ->count();

            // Attendance statistics (current month)
            $currentMonth = now()->month;
            $currentYear = now()->year;
            $attendanceStats = DB::table('attendance')
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->select(
                    DB::raw('count(*) as total_records'),
                    DB::raw('sum(case when status = "present" then 1 else 0 end) as present_count'),
                    DB::raw('sum(case when status = "absent" then 1 else 0 end) as absent_count'),
                    DB::raw('sum(case when status = "late" then 1 else 0 end) as late_count')
                )
                ->first();

            // Recent activities
            $recentStudents = DB::table('admission_forms')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(['id', 'full_name', 'class', 'section', 'created_at']);

            $recentChallans = DB::table('challans')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(['id', 'full_name', 'total_fee', 'status', 'created_at']);

            return response()->json([
                'success' => true,
                'message' => 'Dashboard statistics retrieved successfully',
                'data' => [
                    'students' => [
                        'total' => $totalStudents,
                        'by_class' => $studentsByClass
                    ],
                    'teachers' => [
                        'total' => $totalTeachers,
                        'by_subject' => $teachersBySubject
                    ],
                    'parents' => [
                        'total' => $totalParents
                    ],
                    'fees' => [
                        'total_amount' => $totalFees,
                        'paid_amount' => $paidFees,
                        'unpaid_amount' => $unpaidFees,
                        'overdue_challans' => $overdueChallans,
                        'collection_percentage' => $totalFees > 0 ? round(($paidFees / $totalFees) * 100, 2) : 0
                    ],
                    'library' => [
                        'total_books' => $totalBooks,
                        'available_books' => $availableBooks,
                        'issued_books' => $issuedBooks,
                        'overdue_books' => $overdueBooks
                    ],
                    'attendance' => [
                        'current_month' => $currentMonth,
                        'total_records' => $attendanceStats->total_records ?? 0,
                        'present_count' => $attendanceStats->present_count ?? 0,
                        'absent_count' => $attendanceStats->absent_count ?? 0,
                        'late_count' => $attendanceStats->late_count ?? 0,
                        'attendance_percentage' => $attendanceStats->total_records > 0 
                            ? round(($attendanceStats->present_count / $attendanceStats->total_records) * 100, 2) 
                            : 0
                    ],
                    'recent_activities' => [
                        'students' => $recentStudents,
                        'challans' => $recentChallans
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving dashboard statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recent activities
     */
    public function recentActivities()
    {
        try {
            $activities = [];

            // Recent student admissions
            $recentStudents = DB::table('admission_forms')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(['id', 'full_name', 'class', 'section', 'created_at']);

            foreach ($recentStudents as $student) {
                $activities[] = [
                    'type' => 'student_admission',
                    'title' => 'New Student Admission',
                    'description' => "Student {$student->full_name} admitted to {$student->class} - {$student->section}",
                    'timestamp' => $student->created_at,
                    'icon' => 'user-plus'
                ];
            }

            // Recent fee payments
            $recentPayments = DB::table('challans')
                ->where('status', 'paid')
                ->orderBy('updated_at', 'desc')
                ->limit(10)
                ->get(['id', 'full_name', 'total_fee', 'updated_at']);

            foreach ($recentPayments as $payment) {
                $activities[] = [
                    'type' => 'fee_payment',
                    'title' => 'Fee Payment',
                    'description' => "Fee payment of ${$payment->total_fee} received from {$payment->full_name}",
                    'timestamp' => $payment->updated_at,
                    'icon' => 'dollar-sign'
                ];
            }

            // Recent book issues
            $recentBookIssues = DB::table('book_issues')
                ->join('books', 'book_issues.book_id', '=', 'books.id')
                ->join('admission_forms', 'book_issues.student_id', '=', 'admission_forms.id')
                ->select('book_issues.created_at', 'books.title', 'admission_forms.full_name')
                ->orderBy('book_issues.created_at', 'desc')
                ->limit(10)
                ->get();

            foreach ($recentBookIssues as $issue) {
                $activities[] = [
                    'type' => 'book_issue',
                    'title' => 'Book Issued',
                    'description' => "Book '{$issue->title}' issued to {$issue->full_name}",
                    'timestamp' => $issue->created_at,
                    'icon' => 'book'
                ];
            }

            // Sort activities by timestamp
            usort($activities, function($a, $b) {
                return strtotime($b['timestamp']) - strtotime($a['timestamp']);
            });

            // Limit to 20 most recent activities
            $activities = array_slice($activities, 0, 20);

            return response()->json([
                'success' => true,
                'message' => 'Recent activities retrieved successfully',
                'data' => $activities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving recent activities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get notifications
     */
    public function notifications()
    {
        try {
            $notifications = [];

            // Overdue fee notifications
            $overdueChallans = DB::table('challans')
                ->where('status', 'unpaid')
                ->where('due_date', '<', now())
                ->count();

            if ($overdueChallans > 0) {
                $notifications[] = [
                    'type' => 'warning',
                    'title' => 'Overdue Fees',
                    'message' => "{$overdueChallans} fee challans are overdue",
                    'action_url' => '/api/v1/challans?status=overdue',
                    'created_at' => now()
                ];
            }

            // Overdue book notifications
            $overdueBooks = DB::table('book_issues')
                ->whereNull('return_date')
                ->where('due_date', '<', now())
                ->count();

            if ($overdueBooks > 0) {
                $notifications[] = [
                    'type' => 'warning',
                    'title' => 'Overdue Books',
                    'message' => "{$overdueBooks} books are overdue for return",
                    'action_url' => '/api/v1/book-issues?status=overdue',
                    'created_at' => now()
                ];
            }

            // Low book stock notifications
            $lowStockBooks = DB::table('books')
                ->where('available_copies', '<=', 2)
                ->where('available_copies', '>', 0)
                ->count();

            if ($lowStockBooks > 0) {
                $notifications[] = [
                    'type' => 'info',
                    'title' => 'Low Book Stock',
                    'message' => "{$lowStockBooks} books have low stock (2 or fewer copies available)",
                    'action_url' => '/api/v1/books?available=true',
                    'created_at' => now()
                ];
            }

            // Recent notices
            $recentNotices = DB::table('notices')
                ->where('created_at', '>=', now()->subDays(7))
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(['id', 'title', 'content', 'created_at']);

            foreach ($recentNotices as $notice) {
                $notifications[] = [
                    'type' => 'info',
                    'title' => 'New Notice',
                    'message' => $notice->title,
                    'action_url' => "/api/v1/notices/{$notice->id}",
                    'created_at' => $notice->created_at
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Notifications retrieved successfully',
                'data' => $notifications
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
