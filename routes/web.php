<?php

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

Auth::routes();
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/categories/{categoryId}', 'HomeController@getSchoolsByCategoryId');
Route::get('/categories/{categoryId}/schools/{schoolId}', 'HomeController@getClassesBySchoolId');
Route::get('/categories/{categoryId}/schools/{schoolId}/classes/{classId}/eandl', 'HomeController@showAttendanceForm');
Route::get('/attendances/{attendanceId}/students/{studentId}/enter', 'HomeController@enter');
Route::get('/attendances/{attendanceId}/students/{studentId}/leave', 'HomeController@leave');
