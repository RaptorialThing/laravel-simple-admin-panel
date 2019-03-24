<?php

namespace App\Http\Controllers;

use App\Role, App\UserRoleMapping;
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
        $role = new Role;
        $role->role = $request->rolename;
        $role->description = $request->description;
        $role->save();
        Session::flash('success', "Role created");

        return Redirect::back();
    }

    /**
    * Deletes an existing role
    */
    public function deleteRole(Request $request)
    {
      UserRoleMapping::where('user_role', $request->id)->delete();
      $role = Role::find($request->id);
      $role->delete();
      Session::flash('success', "Role deleted");

      return Redirect::back();
  }

    /**
    * Updates a role
    */
    public function updateRole(Request $request)
    {
        $role = Role::find($request->id);
        $role->description = $request->description;
        $role->role = $request->role;
        $role->save();

        Session::flash('success', "Role updated");
        return Redirect::back();
    }
}
