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

Route::get('/', 'HomeController@index');
Route::controllers([
	'home' => 'HomeController',
	'partner' => 'PartnerController',
	'task' => 'TaskController',
	'photo' => 'PhotoController',
	'object' => 'ObjectController',
	'01/ac' => 'AutocompleteController',
	'01/fc' => 'FileController',
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
