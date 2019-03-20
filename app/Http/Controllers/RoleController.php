<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Redirect, QueryException, Session;

class RoleController extends Controller
{
	protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
    * Creates a new role
    */
    public function createRole(Request $request)
    {
    	try {
    		DB::table('available_roles')->insert(['role' => $request["rolename"],
    			'description' => $request["description"]]);
    	}
    	catch (\Illuminate\Database\QueryException $e)
    	{
    		return Redirect::back()->withErrors("Error creating role");
    	};

    	Session::flash('success', "Role created");

    	return Redirect::back();
    }

    /**
    * Deletes an existing role
    */
    public function deleteRole(Request $request)
    {
    	try {
    		DB::table('current_roles')->where('user_role', $request->id)->delete();
    		DB::table('available_roles')->where('id', $request->id)->delete();
    	}
    	catch (\Illuminate\Database\QueryException $e)
    	{
    		return Redirect::back()->withErrors("Error deleting role");
    	}
    	Session::flash('success', "Role deleted");
    	return Redirect::back();
    }

    /**
    * Updates a role
    */
    public function updateRole(Request $request)
    {
    	print_r($request->id);
    	try {
    	DB::table('available_roles')
            ->where('id', $request->id)
            ->update(['description' => $request->description,
        			'role' => $request->role]);
		}
		catch (\Illuminate\Database\QueryException $e)
    	{
    		return Redirect::back()->withErrors("Error modifying role");
    	}
    	Session::flash('success', "Role deleted");
    	return Redirect::back();
    }
}
