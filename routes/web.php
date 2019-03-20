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




Auth::routes();

Route::group(['middleware' => 'admin:admin'], function () {
	Route::resource('admin', 'UserController');
	Route::post('/admin/createUser', 'UserController@createUser');
	Route::post('/admin/createRole', 'RoleController@createRole');
	Route::get('/admin/deleteRole/{id}', 'RoleController@deleteRole');
	Route::get('/admin/editRole/{id}', 'RoleController@editRole');
	Route::post('/admin/addRoleToUser', 'UserController@addRoleToUser');
	Route::post('/admin/deleteRoleFromUser', 'UserController@deleteRoleFromUser');
	Route::post('/admin/updateRole/{id}', 'RoleController@updateRole');
});

Route::get('/home', 'HomeController@index')->name('home');
