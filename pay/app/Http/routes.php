<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@new_home');

Route::get('new_home', 'HomeController@new_home');

Route::post('home', 'HomeController@index');

Route::get('/changePassword','HomeController@showChangePasswordForm');

//* Old Payslip

Route::post('payslip', 'HomeController@payslip');

Route::post('new_payslip', 'HomeController@new_payslip');
  
Route::get('import', 'HomeController@import');

Route::post('import', 'HomeController@import');
Route::get('payroll/upload', 'PayrollController@upload');
Route::post('payroll/upload', 'PayrollController@upload');
Route::resource('vici-users','ViciUsersController');
Route::resource('masterlist','MasterlistsController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);