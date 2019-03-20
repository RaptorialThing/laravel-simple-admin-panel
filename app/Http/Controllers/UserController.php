<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Redirect, QueryException, Session;

class UserController extends Controller
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
    * The main view to edit everything
    */
    public function index()
    {
        $data =  ["users" => DB::table('users')->select("name", "email", "id")->get(),
        "roles" =>  DB::table('available_roles')->select("role", "id", "description")->get()];
        return view('admin/main')->with($data);
    }
    /**
    * Deletes a user
    */
    public function destroy(Request $request)
    {
        try {
            DB::table('users')->where('id', $request->userId)->delete();
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return Redirect::back()->withErrors("Error deleting user");
        };

        Session::flash('success', "User deleted");
        return redirect()->back();
    }
    /**
    * Returns the page to edit user roles
    */
    public function edit(Request $request)
    {

        $roles =  DB::table('current_roles')->select("user_id", "name", "role", "description", "email", "user_role", "users.id")->leftJoin('users', 'current_roles.user_id', '=', 'users.id')->leftJoin('available_roles', 'current_roles.user_role', '=', 'available_roles.id')->where('user_id', $request->userId)->get();
        $available_roles = DB::table('available_roles')->select("id", "role", "description")->get();
        return view('admin/edit')->with(["roles" => $roles, "availableRoles" => $available_roles, "userId" => $request->userId]);
    }

    /** 
    * Adds a role to an existing user
    */
    public function addRoleToUser(Request $request)
    {
       try {
        DB::table('current_roles')->insert(['user_role' => $request->roleToAdd, 
            'user_id' => $request->userId]);
    }
    catch (\Illuminate\Database\QueryException $e)
    {
     return Redirect::back()->withErrors("Error adding role to user");
     }
     Session::flash('success', "Role added to user");
     return Redirect::back();
    }

    /** 
    * Removes a role from an existing user
    */
    public function deleteRoleFromUser(Request $request)
    {
       try {
        DB::table('current_roles')->where('user_id', $request->userId)->where('user_role', $request->roleToRemove)->delete();
    }
    catch (\Illuminate\Database\QueryException $e)
    {
     return Redirect::back()->withErrors("Error deleting role from user");
    }
    Session::flash('success', "Role deleted from user");
    return Redirect::back();
    }

    /**
    * Creates a new user
    */
    public function createUser(Request $request)
    {
        // Creates the user with "none" role and submitted info
      try {
        DB::table('users')->insert(['email' => $request->email, 
         'name' => $request->username,
         'password' => bcrypt($request->password)]);
        }

        catch (\Illuminate\Database\QueryException $e)
        {
            return Redirect::back()->withErrors("Error creating user");
        };

        Session::flash('success', "User created");
        return Redirect::back();
    }
}
