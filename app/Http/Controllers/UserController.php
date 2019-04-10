<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRoleMapping;
use Illuminate\Http\Request;
use App\Http\Requests\UserCreationRequest;
use DB;
use Redirect;
use QueryException;
use Session;

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
        $users = User::select("name", "email", "id")->get();
        $roles =  Role::select("role", "id", "description")->get();

        return view('admin/main')->with(compact('users', 'roles'));
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
    public function edit(Request $request, $id)
    {
        $roles =  UserRoleMapping::first("user_id", "name", "role", "description", "email", "role_id", "users.id")
        ->leftJoin('users', 'current_roles.user_id', '=', 'users.id')
        ->leftJoin('available_roles', 'current_roles.role_id', '=', 'available_roles.id')
        ->where('user_id', $request->userId)->get();
        $availableRoles = Role::select("id", "role", "description")->get();
        $userId = $id;

        return view('admin/edit')->with(compact('roles', 'availableRoles', 'userId'));
    }

    /**
    * Adds a role to an existing user
    */
    public function addRoleToUser(Request $request)
    {
        User::find($request->userId)->roles()->attach($request->roleToAdd);
        Session::flash('success', "Role added to user");

        return Redirect::back();
    }

    /**
    * Removes a role from an existing user
    */
    public function deleteRoleFromUser(Request $request)
    {
        User::find($request->userId)->roles()->detach($request->roleToRemove);
        Session::flash('success', "Role deleted from user");

        return Redirect::back();
    }

    /**
    * Creates a new user
    */
    public function create(UserCreationRequest $request)
    {
        // Creates the user with "none" role and submitted info
        $user = new User;
        $user->fill($request->input());
        $user->password = bcrypt($request->password);
        $user->save();
        Session::flash('success', "User created");
        
        return Redirect::back();
    }
}
