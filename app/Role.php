<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
* List of existing roles, containing description and name
*/
class Role extends Model
{
    protected $table = 'available_roles';

    public $timestamps = false;
}
