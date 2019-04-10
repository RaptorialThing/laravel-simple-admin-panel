<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Checks if the user is authenticated first
        if (!Auth::check()) {
            return redirect('/login');
        };

        // Check if the user has required role
        if ($roles == null || $this->hasRole($roles)) {
            return $next($request);
        }

        // Else redirect to home
        return redirect('/');
    }

    /**
     * Return the list of roles the user has
     */
    public function getRoles()
    {
        $id =  Auth::id();
        $roles = \App\Models\User::find($id)->roles;

        return $roles;
    }
    /** Check if the current logged-in user has at least one role within the required roles
    * @param array  $checkAgainst the list of roles to match against
    */
    public function hasRole($checkAgainst)
    {
        $userRoles = $this->getRoles();

        foreach ($checkAgainst as $role) {
            foreach ($userRoles as $usrRole) {
                if ($usrRole->role == $role) {
                    return true;
                }
            }
        }

        return false;
    }
}
