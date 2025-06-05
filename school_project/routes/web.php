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
Route::get('/student', 'StudentController@student')->name('student');
Route::get('/teacher', 'TeachersController@teacher')->name('teacher');
Route::get('/parent', 'ParentsController@parent')->name('parent');
Route::get('/add-teacher', 'AddTeacherController@addTeacher')->name('addteacher');
Route::get('/admit-form', 'AdmissionFormController@addStudent')->name('addstudent');
Route::get('/add-parent', 'AddParentController@addParent')->name('addparent');
Route::get('/all-student', 'AllStudentsController@allStudent')->name('allstudent');
Route::get('/all-teacher', 'AllTeachersController@allTeacher')->name('allteacher');
Route::get('/all-parents', 'AllParentsController@allParent')->name('allparent');
Route::get('/student-details', 'StudentDetailsController@studentDetails')->name('studentdetails');
Route::get('/teacher-details', 'TeacherDetailsController@teacherDetails')->name('teacherdetails');
Route::get('/parents-details', 'ParentsDetailsController@parentDetails')->name('parentdetails');
Route::get('/student-promotion', 'StudentPromotionController@studentPromotion')->name('studentpromotion');
Route::get('/teacher-payment', 'TeacherPaymentController@teacherPayment')->name('teacherpayment');
