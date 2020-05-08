<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleModule extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'roles_modules';
    
    public $timestamps = false;

    public function check_module_if_checked($moduleID, $roleID)
    {
        $count = self::where([
            'module_id' => $moduleID,
            'role_id' => $roleID,
            'is_active' => 1
        ])->count();

        return $count;
    }
}

