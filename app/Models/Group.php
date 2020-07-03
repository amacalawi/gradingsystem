<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = ['id'];

    protected $table = 'groups';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $group = self::find($id);
        if ($group) {
            $results = array(
                'id' => ($group->id) ? $group->id : '',
                'code' => ($group->code) ? $group->code : '',
                'name' => ($group->name) ? $group->name : '',
                'description' => ($group->description) ? $group->description : ''
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

}
