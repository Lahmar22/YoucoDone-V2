<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $table = 'role';

    protected $fillable = [
        'name',
        'guard_name',
        'description',
    ];

    
    
}
