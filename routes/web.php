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

 Route::resource('users','HomeController');
Route::get('/users/add/add/add', 'HomeController@add');
 Route::get('/users/getdata/getdata/getdata', 'HomeController@getdata');


Route::resource('departments','DepartmentController');


Route::resource('employees','EmployeeController');

//For importing the csv or xls or xlsx
 Route::get('/add_import', 'EmployeeController@add_import')->name('employees.add_import');
 Route::post('/employees/import', 'EmployeeController@import')->name('employees.import');

Route::resource('tasks', 'TaskController');

Auth::routes();
// Auth::logout();

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
// Ignores notices and reports all other kinds... and warnings
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
// error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}