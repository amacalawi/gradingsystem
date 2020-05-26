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
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'type' => '',
            );
        }
        return (object) $results;
    }

    public function get_all_sections()
    {
        $sections = self::where('is_active', 1)->orderBy('id', 'asc')->get();
        
        $secs = array();
        $secs[] = array('0' => 'select a section');

        foreach ($sections as $section) {
            $secs[] = array(
                $section->id  => $section->name,
            );
        }

        $sections = array();
        foreach($secs as $sec) {
            foreach($sec as $key => $val) {
                $sections[$key] = $val;
            }
        }

        return $sections;  
    }

    public function get_all_sections_bytype($type)
    {
        $sections = self::where('is_active', 1)->where('type', $type)->orderBy('id', 'asc')
        ->whereNotIn('id',function($query) {
            $query->select('section_id')->from('admissions');
        })->get();
        

        $secs = array();
        $secs[] = array('0' => 'select a section');

        foreach ($sections as $section) {
            $secs[] = array(
                $section->id  => $section->name,
            );
        }

        $sections = array();
        foreach($secs as $sec) {
            foreach($sec as $key => $val) {
                $sections[$key] = $val;
            }
        }

        return $sections;  
    }
}
