<?php

namespace App\Http\Controllers;

use App\User;
use App\Role, App\UserRoleMapping;
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
        $data =  [
            "users" => User::select("name", "email", "id")->get(),
            "roles" =>  Role::select("role", "id", "description")->get()
        ];

        return view('admin/main')->with($data);
    }
    /**
    * Deletes a user
    */
    public function destroy(Request $request)
    {
        User::destroy($request->userId);
        Session::flash('success', "User deleted");

        return redirect()->back();
    }
    /**
    * Returns the page to edit user roles
    */
    public function edit(Request $request)
    {
        $roles =  UserRoleMapping::first("user_id", "name", "role", "description", "email", "user_role", "users.id")
        ->leftJoin('users', 'current_roles.user_id', '=', 'users.id')
        ->leftJoin('available_roles', 'current_roles.user_role', '=', 'available_roles.id')
        ->where('user_id', $request->userId)->get();
        $available_roles = Role::select("id", "role", "description")->get();

        return view('admin/edit')->with([
            "roles" => $roles, 
            "availableRoles" => $available_roles, 
            "userId" => $request->userId,
        ]);
    }

    /** 
    * Adds a role to an existing user
    */
    public function addRoleToUser(Request $request)
    {
        $userRole = new UserRoleMapping;
        $userRole->user_role = $request->roleToAdd;
        $userRole->user_id = $request->userId;
        $userRole->save();
        Session::flash('success', "Role added to user");

        return Redirect::back();
    }

    /** 
    * Removes a role from an existing user
    */
    public function deleteRoleFromUser(Request $request)
    {
        UserRoleMapping::where('user_id', $request->userId)->where('user_role', $request->roleToRemove)->delete();
        Session::flash('success', "Role deleted from user");

        return Redirect::back();
    }

    /**
    * Creates a new user
    */
    public function createUser(Request $request)
    {
        // Creates the user with "none" role and submitted info
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();
        Session::flash('success', "User created");
        
        return Redirect::back();
    }
}
