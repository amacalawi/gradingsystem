<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleHeader extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'roles_headers';
    
    public $timestamps = false;

    public function check_header_if_checked($headerID, $roleID)
    {
        $count = self::where([
            'header_id' => $headerID,
            'role_id' => $roleID,
            'is_active' => 1
        ])->count();

        return $count;
    }
}

