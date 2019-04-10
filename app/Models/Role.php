<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
* List of existing roles, containing description and name
*/
class Role extends Model
{
    protected $table = 'available_roles';

    public $timestamps = false;

    protected $fillable = [
        'role', 'description',
    ];

    public function user()
    {
        return $this->belongsToMany('App\Models\User', 'current_roles');
    }
}
