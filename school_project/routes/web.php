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
Route::get('/add-teacher', 'AddTeacherController@addteacher')->name('addteacher');
Route::get('/admit-form', 'AdmissionFormController@addstudent')->name('addstudent');
Route::get('/add-parent', 'AddParentController@addparent')->name('addparent');