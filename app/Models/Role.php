<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'roles';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $role = self::find($id);
        if ($role) {
            $results = array(
                'id' => ($role->id) ? $role->id : '',
                'code' => ($role->code) ? $role->code : '',
                'name' => ($role->name) ? $role->name : '',
                'description' => ($role->description) ? $role->description : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => ''
            );
        }
        return (object) $results;
    }

    public function all_roles()
    {	
    	$roles = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $rolex = array();
        $rolex[] = array('' => 'select a role');
        foreach ($roles as $role) {
            $rolex[] = array(
                $role->id => $role->name
            );
        }

        $roles = array();
        foreach($rolex as $desig) {
            foreach($desig as $key => $val) {
                $roles[$key] = $val;
            }
        }

        return $roles;
    }
}

