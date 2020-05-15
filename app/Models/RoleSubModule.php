<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleSubModule extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'roles_sub_modules';
    
    public $timestamps = false;

    public function check_sub_module_if_checked($subModuleID, $roleID)
    {
        $res = self::where([
            'sub_module_id' => $subModuleID,
            'role_id' => $roleID,
            'is_active' => 1
        ])->get();

        if ($res->count() > 0) {
            $permission = explode(',', $res->first()->permissions);
            $res = array(
                'count' => 1,
                'create' => $permission[0],
                'read' => $permission[1],
                'update' => $permission[2],
                'delete' => $permission[3]
            );
        } else {
            $res = array(
                'count' => 0,
                'create' => 0,
                'read' => 0,
                'update' => 0,
                'delete' => 0
            );
        }

        return $res;
    }

    public function sub_module()
    {   
        return $this->belongsTo('App\Models\SubModule');
    }
}

