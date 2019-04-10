<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\UserRoleMapping;
use Illuminate\Http\Request;
use App\Http\Requests\RoleCreationRequest;
use DB;
use Redirect;
use QueryException;
use Session;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RoleCreationRequest $request)
    {
        $role = new Role;
        $role->role = $request->role;
        $role->description = $request->description;
        $role->save();
        Session::flash('success', "Role created");

        return Redirect::back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleCreationRequest $request, $id)
    {
        $role = Role::find($id);
        $role->description = $request->description;
        $role->role = $request->role;
        $role->save();

        Session::flash('success', "Role updated");
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
        Session::flash('success', "Role deleted");

        return Redirect::back();
    }
}
