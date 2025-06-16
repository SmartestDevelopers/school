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
Route::post('/add-teacher', 'TeachersController@store')->name('addteacher.store');
Route::get('/admit-form', 'StudentController@create')->name('admitform');



Route::get('/view-student/{id}', 'StudentController@viewStudent');
Route::get('/edit-student/{id}', 'StudentController@editStudent');
Route::post('/update-student', 'StudentController@updateStudent');
Route::get('/delete-student/{id}', 'StudentController@deleteStudent');

Route::get('/view-teacher/{id}', 'TeachersController@viewTeacher')->name('viewTeacher');
Route::get('/edit-teacher/{id}', 'TeachersController@editTeacher');
Route::post('/update-teacher', 'TeachersController@updateTeacher')->name('updateTeacher');
Route::get('/delete-teacher/{id}', 'TeachersController@deleteTeacher');

// Show edit form (GET)
Route::get('/edit-transport/{id}', 'TransportController@edit')->name('transport.edit');

// Update transport (PUT or PATCH)
Route::put('/update-transport/{id}', 'TransportController@update')->name('transport.update');

// Delete transport (DELETE)
Route::delete('/delete-transport/{id}', 'TransportController@destroy')->name('transport.destroy');



Route::post('/admit-form', 'StudentController@store')->name('admitform.store');
Route::get('/add-parent', 'ParentsController@create')->name('addparent');
Route::post('/add-parent', 'ParentsController@store')->name('addparent.store');
Route::get('/all-student', 'StudentController@allStudent')->name('allstudent');
// this all-student is showing blank page, 
Route::get('/all-teacher', 'TeachersController@allTeacher')->name('allteacher');
Route::get('/all-parents', 'ParentsController@allParent')->name('allparent');

Route::get('/view-parent/{id}', 'ParentsController@viewParent');
Route::get('/edit-parent/{id}', 'ParentsController@editParent');
Route::post('/update-parent', 'ParentsController@updateParent')->name('update-parent');
Route::get('/delete-parent/{id}', 'ParentsController@deleteParent');

Route::get('/all-class', 'ClassController@allClass')->name('allclass');
Route::get('/add-class', 'ClassController@create')->name('addclass');
Route::post('/add-class', 'ClassController@store')->name('class.store');
Route::get('/edit-class/{id}', 'ClassController@editClass')->name('editClass');
Route::post('/update-class', 'ClassController@updateClass')->name('updateClass');
Route::get('/delete-class/{id}', 'ClassController@deleteClass')->name('deleteClass');


Route::get('/list-fee-type', 'FeeController@addFee')->name('addfeetype');
Route::post('/list-fee-type', 'FeeController@store')->name('addfeetype.store');
Route::get('/edit-fee-type/{id}', 'FeeController@edit')->name('addfeetype.edit');
Route::post('/update-fee-type/{id}', 'FeeController@update')->name('addfeetype.update');

Route::get('/student-promotion', 'StudentController@studentPromotion')->name('studentpromotion');
Route::get('/teacher-payment', 'TeachersController@teacherPayment')->name('teacherpayment');
Route::get('/add-book', 'LibraryController@create')->name('addbook');
Route::post('/add-book', 'LibraryController@store')->name('addbook.store');
Route::get('/all-book', 'LibraryController@allBook')->name('allbook');
Route::get('/all-fees', 'AccountController@allFees')->name('allfees');
Route::get('/add-expense', 'AccountController@create')->name('addexpense');
Route::post('/add-expense', 'AccountController@store')->name('addexpense.store');
Route::get('/all-expense', 'AccountController@allExpense')->name('allexpense');
Route::get('/account-settings', 'AccountController@accountSettings')->name('accountsettings');
Route::post('/account-settings', 'AccountController@store')->name('accountsettings.store');

Route::post('/add-class', 'ClassController@store')->name('class.store');
Route::get('/class-routine', 'ClassController@classRoutine')->name('classroutine');
Route::post('/class-routine', 'ClassController@store')->name('classroutine.store');
Route::get('/all-subject', 'SubjectController@allSubject')->name('allsubject');
Route::post('/all-subject', 'SubjectController@store')->name('allsubject.store');
Route::get('/student-attendence', 'AttendenceController@studentAttendence')->name('studentattendence');
Route::get('/modal', 'UielementsController@modal')->name('modal');
Route::get('/notification-alart', 'UielementsController@alart')->name('alart');
Route::get('/progress-bar', 'UielementsController@progressBar')->name('progressbar');
Route::get('/button', 'UielementsController@button')->name('button');
Route::get('/grid', 'UielementsController@grid')->name('grid');
Route::get('/ui-tab', 'UielementsController@uitab')->name('uitab');
Route::get('/ui-widget', 'UielementsController@uiwidget')->name('uiwidget');
Route::get('/transport', 'TransportController@transport')->name('transport');
Route::post('/transport', 'TransportController@store')->name('transport.store');
Route::get('/map', 'MapController@map')->name('map');
Route::get('/notice-board', 'NoticeController@noticeBoard')->name('noticeboard');
Route::post('/notice-board', 'NoticeController@store')->name('notice.store');
Route::get('/messaging', 'MessagingController@messaging')->name('messaging');
Route::post('/messaging', 'MessagingController@store')->name('messaging.store');
Route::get('/hostel', 'HostelController@hostel')->name('hostel');
Route::get('/exam-grade', 'ExamController@examGrade')->name('examgrade');
Route::post('/exam-grade', 'ExamController@store')->name('examgrade.store');
Route::get('/exam-schedule', 'ExamController@examSchedule')->name('examschedule');
Route::post('/exam-schedule', 'ExamController@store')->name('examschedule.store');