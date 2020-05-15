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
                'level_id' => ($section->level_id) ? $section->level_id : '',
                'schoolyear_id' => ($section->schoolyear_id) ? $section->schoolyear_id : '',
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'level_id' => '',
                'schoolyear_id' => ''
            );
        }
        return (object) $results;
    }
}
