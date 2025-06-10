<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/add-teacher', 'TeachersController@create')->name('addteacher');
Route::get('/admit-form', 'StudentController@create')->name('admitform');
Route::post('/admit-form', 'StudentController@store')->name('admitform.store');
Route::get('/add-parent', 'ParentsController@create')->name('addparent');
Route::get('/all-student', 'StudentController@allStudent')->name('allstudent');
Route::get('/all-teacher', 'TeachersController@allTeacher')->name('allteacher');
Route::get('/all-parents', 'ParentsController@allParent')->name('allparent');
Route::get('/student-details', 'StudentController@studentDetails')->name('studentdetails');
Route::get('/teacher-details', 'TeachersController@teacherDetails')->name('teacherdetails');
Route::get('/parents-details', 'ParentsController@parentDetails')->name('parentdetails');
Route::get('/student-promotion', 'StudentController@studentPromotion')->name('studentpromotion');
Route::get('/teacher-payment', 'TeachersController@teacherPayment')->name('teacherpayment');
Route::get('/add-book', 'LibraryController@create')->name('addbook');
Route::get('/all-book', 'LibraryController@allBook')->name('allbook');
Route::get('/all-fees', 'AccountController@allFees')->name('allfees');
Route::get('/add-expense', 'AccountController@create')->name('addexpense');
Route::get('/all-expense', 'AccountController@allExpense')->name('allexpense');
Route::get('/account-settings', 'AccountController@accountSettings')->name('accountsettings');
Route::get('/all-class', 'ClassController@allClass')->name('allclass');
Route::get('/add-class', 'ClassController@create')->name('addclass');
Route::get('/class-routine', 'ClassController@classRoutine')->name('classroutine');
Route::get('/all-subject', 'SubjectController@allSubject')->name('allsubject');
Route::get('/student-attendence', 'AttendenceController@studentAttendence')->name('studentattendence');
Route::get('/modal', 'UielementsController@modal')->name('modal');
Route::get('/notification-alart', 'UielementsController@alart')->name('alart');
Route::get('/progress-bar', 'UielementsController@progressBar')->name('progressbar');
Route::get('/button', 'UielementsController@button')->name('button');
Route::get('/grid', 'UielementsController@grid')->name('grid');
Route::get('/ui-tab', 'UielementsController@uitab')->name('uitab');
Route::get('/ui-widget', 'UielementsController@uiwidget')->name('uiwidget');
Route::get('/transport', 'TransportController@transport')->name('transport');
Route::get('/map', 'MapController@map')->name('map');
Route::get('/notice-board', 'NoticeController@noticeBoard')->name('noticeboard');
Route::get('/messaging', 'MessagingController@messaging')->name('messaging');
Route::get('/hostel', 'HostelController@hostel')->name('hostel');
Route::get('/exam-grade', 'ExamController@examGrade')->name('examgrade');
Route::get('/exam-schedule', 'ExamController@examSSchedule')->name('examschedule');