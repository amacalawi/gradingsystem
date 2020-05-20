<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $guarded = ['id'];

    protected $table = 'sections';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $section = self::find($id);
        if ($section) {
            $results = array(
                'id' => ($section->id) ? $section->id : '',
                'code' => ($section->code) ? $section->code : '',
                'name' => ($section->name) ? $section->name : '',
                'description' => ($section->description) ? $section->description : '',
                'type' => ($section->type) ? $section->type : '',
                'level_id' => ($section->level_id) ? $section->level_id : '',
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'type' => '',
                'level_id' => '',
            );
        }
        return (object) $results;
    }
}
