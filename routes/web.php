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

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users','HomeController');

Route::resource('departments','DepartmentController');

Route::post('department/search', 'DepartmentController@search')->name('department.search');

Route::resource('employee','EmployeeController');

Auth::routes();
// Auth::logout();