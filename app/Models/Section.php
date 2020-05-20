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

    public function all_sections($entity = '')
    {	
    	$sections = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $sectionx = array();
        $sectionx[] = array('' => 'select a section');
        foreach ($sections as $section) {
            $sectionx[] = array(
                $section->id => $section->name
            );
        }

        $sections = array();
        foreach($sectionx as $section) {
            foreach($section as $key => $val) {
                $sections[$key] = $val;
            }
        }

        return $sections;
    }

    public function get_column_via_identifier($column, $id)
    {
        return self::where('id', $id)->first()->$column;
    }
}
