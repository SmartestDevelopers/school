<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});





// API Routes for Mobile Application
Route::prefix('v1')->group(function () {
    Route::apiResource('students', 'Api\StudentController');
    Route::apiResource('teachers', 'Api\TeacherController');
    Route::apiResource('parents', 'Api\ParentController');

    // Authentication Routes
    Route::post('login', 'Api\AuthController@login');
    Route::post('register', 'Api\AuthController@register');
    Route::post('logout', 'Api\AuthController@logout')->middleware('auth:sanctum');
    Route::post('refresh', 'Api\AuthController@refresh')->middleware('auth:sanctum');
    
    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        
        // Student Management API
        //Route::apiResource('students', 'Api\StudentController');
        Route::get('students/{id}/details', 'Api\StudentController@details');
        Route::post('students/{id}/promote', 'Api\StudentController@promote');
        
        // Teacher Management API
        //Route::apiResource('teachers', 'Api\TeacherController');
        Route::get('teachers/{id}/details', 'Api\TeacherController@details');
        Route::get('teachers/{id}/payments', 'Api\TeacherController@payments');
        Route::post('teachers/{id}/payment', 'Api\TeacherController@addPayment');
        
        // Parent Management API
        //Route::apiResource('parents', 'Api\ParentController');
        Route::get('parents/{id}/children', 'Api\ParentController@children');
        Route::get('parents/{id}/details', 'Api\ParentController@details');
        
        // Class Management API
        Route::apiResource('classes', 'Api\ClassController');
        Route::get('classes/{id}/students', 'Api\ClassController@students');
        Route::get('classes/{id}/subjects', 'Api\ClassController@subjects');
        Route::get('classes/{id}/routine', 'Api\ClassController@routine');
        Route::post('classes/{id}/routine', 'Api\ClassController@storeRoutine');
        
        // Subject Management API
        Route::apiResource('subjects', 'Api\SubjectController');
        Route::get('subjects/{id}/classes', 'Api\SubjectController@classes');
        Route::get('subjects/{id}/teachers', 'Api\SubjectController@teachers');
        
        // Fee Management API
        Route::apiResource('fees', 'Api\FeeController');
        Route::apiResource('fee-types', 'Api\FeeTypeController');
        Route::get('fees/class/{class_id}', 'Api\FeeController@byClass');
        Route::get('fees/student/{student_id}', 'Api\FeeController@byStudent');
        
        // Challan Management API
        Route::apiResource('challans', 'Api\ChallanController');
        Route::get('challans/{id}/pdf', 'Api\ChallanController@downloadPdf');
        Route::post('challans/{id}/pay', 'Api\ChallanController@markPaid');
        Route::get('challans/student/{student_id}', 'Api\ChallanController@byStudent');
        Route::get('challans/class/{class_id}', 'Api\ChallanController@byClass');
        
        // Attendance Management API
        Route::apiResource('attendance', 'Api\AttendanceController');
        Route::get('attendance/class/{class_id}/date/{date}', 'Api\AttendanceController@byClassAndDate');
        Route::get('attendance/student/{student_id}/month/{month}', 'Api\AttendanceController@byStudentAndMonth');
        Route::post('attendance/bulk', 'Api\AttendanceController@bulkStore');
        
        // Library Management API
        Route::apiResource('books', 'Api\BookController');
        Route::apiResource('book-issues', 'Api\BookIssueController');
        Route::get('books/available', 'Api\BookController@available');
        Route::get('book-issues/student/{student_id}', 'Api\BookIssueController@byStudent');
        Route::post('book-issues/{id}/return', 'Api\BookIssueController@returnBook');
        
        // Exam Management API
        Route::apiResource('exams', 'Api\ExamController');
        Route::apiResource('exam-schedules', 'Api\ExamScheduleController');
        Route::apiResource('exam-grades', 'Api\ExamGradeController');
        Route::get('exams/{id}/results', 'Api\ExamController@results');
        Route::post('exams/{id}/results', 'Api\ExamController@storeResults');
        
        // Transport Management API
        Route::apiResource('transports', 'Api\TransportController');
        Route::get('transports/route/{route}', 'Api\TransportController@byRoute');
        Route::get('transports/{id}/students', 'Api\TransportController@students');
        
        // Notice Management API
        Route::apiResource('notices', 'Api\NoticeController');
        Route::get('notices/recent', 'Api\NoticeController@recent');
        Route::get('notices/class/{class_id}', 'Api\NoticeController@byClass');
        
        // Message Management API
        Route::apiResource('messages', 'Api\MessageController');
        Route::get('messages/inbox', 'Api\MessageController@inbox');
        Route::get('messages/sent', 'Api\MessageController@sent');
        Route::post('messages/{id}/read', 'Api\MessageController@markAsRead');
        
        // Account/Expense Management API
        Route::apiResource('expenses', 'Api\ExpenseController');
        Route::get('expenses/monthly/{month}/{year}', 'Api\ExpenseController@monthly');
        Route::get('expenses/category/{category}', 'Api\ExpenseController@byCategory');
        
        // Reports API
        Route::get('reports/students/total', 'Api\ReportController@totalStudents');
        Route::get('reports/students/class/{class_id}', 'Api\ReportController@studentsByClass');
        Route::get('reports/fees/total', 'Api\ReportController@totalFees');
        Route::get('reports/fees/collective', 'Api\ReportController@collectiveFees');
        Route::get('reports/attendance/class/{class_id}/month/{month}', 'Api\ReportController@attendanceReport');
        
        // Dashboard API
        Route::get('dashboard/stats', 'Api\DashboardController@stats');
        Route::get('dashboard/recent-activities', 'Api\DashboardController@recentActivities');
        Route::get('dashboard/notifications', 'Api\DashboardController@notifications');
        
        // Settings API
        Route::get('settings', 'Api\SettingController@index');
        Route::post('settings', 'Api\SettingController@update');
        
        // File Upload API
        Route::post('upload/image', 'Api\FileController@uploadImage');
        Route::post('upload/document', 'Api\FileController@uploadDocument');
        
    });
    
    // Public Routes (No Authentication Required)
    Route::get('school/info', 'Api\PublicController@schoolInfo');
    Route::get('notices/public', 'Api\PublicController@publicNotices');
    
});
