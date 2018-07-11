<<?php
use Illuminate\Http\Request;
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
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// for passport register 
 Route::post('register',array('before' => 'isJson', 'uses' => 'API\AuthController@register'));
 
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('get-users', 'API\PassportController@getDetails');
});
// Route::get('/get-users', function (Request $request) {
//     return $request->user();
// })->middleware("auth:api");
Route::group([
    'prefix' => 'auth',['middleware' => 'auth:api']
], function () {
    Route::post('login', 'API\AuthController@login');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'API\AuthController@logout');
    });
});
//Route::resource('users','API\HomeController');
Route::get('users',array('before' => 'isJson', 'uses' => 
	'API\PassportController@index'));
// Route::post('users',array('before' => 'isJson', 'uses' => 
// 	'API\HomeController@store'));
// Route::get('users/{user}',array('before' => 'isJson', 'uses' => 
// 	'API\HomeController@show'));
// Route::patch('users/{user}',array('before' => 'isJson', 'uses' => 
// 	'API\HomeController@update'));
// Route::delete('users/{user}',array('before' => 'isJson', 'uses' => 
// 	'API\HomeController@destroy'));
// Route::resource('departments','API\DepartmentController');
Route::middleware('auth:api')->group( function () {
    Route::get('departments',array('before' => 'isJson', 'uses' => 
	'API\DepartmentController@index'));
    Route::get('departments/{department}',array('before' => 'isJson', 'uses' => 
	'API\DepartmentController@show'));
Route::post('departments',array('before' => 'isJson', 'uses' => 
	'API\DepartmentController@store'));
Route::patch('departments/{department}',array('before' => 'isJson', 'uses' => 
	'API\DepartmentController@update'));
Route::delete('departments/{department}',array('before' => 'isJson', 'uses' => 
	'API\DepartmentController@destroy'));
});
// Route::resource('employees','API\EmployeeController');
Route::middleware('auth:api')->group( function () {
Route::get('employees',array('before' => 'isJson', 'uses' => 'API\EmployeeController@index'));
Route::get('employees/{employee}',array('before' => 'isJson', 'uses' => 'API\EmployeeController@show'));
Route::post('employees',array('before' => 'isJson', 'uses' => 'EmployeeController@store'));
Route::delete('employees/{employee}',array('before' => 'isJson', 'uses' => 'API\EmployeeController@destroy'));
Route::patch('employees/{employee}',array('before' => 'isJson', 'uses' => 
	'API\EmployeeController@update'));
});
// Route::resource('tasks', 'API\TaskController');
Route::middleware('auth:api')->group( function () {
Route::get('tasks',array('before' => 'isJson', 
	'uses' => 'API\TaskController@index'));
Route::get('tasks/{task}',array('before' => 'isJson', 'uses' => 'API\TaskController@show'));
Route::post('tasks',array('before' => 'isJson', 'uses' =>
 'API\TaskController@store'));
Route::patch('tasks/{task}',array('uses' => 'API\TaskController@update'));
Route::delete('tasks/{task}',array('before' => 'isJson', 'uses' => 'API\TaskController@destroy'));
});
// Route::group(['namespace' => 'api'], function () {
//     Route::get('/login', 'API\HomeController@login');
// });