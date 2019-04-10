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


// Check against middleware admin that we have the role admin; all below routes require it
Route::group(['middleware' => 'admin:admin'], function () {
    // Routes for Users & Role creation
	Route::resource('admin', 'UserController', ['only' => ['index', 'destroy', 'edit', 'create']]);
    Route::resource('role', 'RoleController', ['only' => ['create', 'destroy', 'update']]);
    // Routes for user to role mapping
    Route::post('/admin/addRoleToUser', 'UserController@addRoleToUser');
    Route::post('/admin/deleteRoleFromUser', 'UserController@deleteRoleFromUser');
});

Route::get('/home', 'HomeController@index')->name('home');
