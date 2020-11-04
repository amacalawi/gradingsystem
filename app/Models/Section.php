<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SectionInfo;
use App\Models\Component;

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
                'education_type_id' => ($section->education_type_id) ? $section->education_type_id : '',
                'level_id' => ($section->level_id) ? $section->level_id : '',
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'education_type_id' => '',
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
                $section->id  => $section->name,
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

    public function get_all_sections_type()
    {
        $sections = self::with([
            'edtype' => function($q) { 
                $q->select(['id', 'code', 'name']); 
            }
        ])
        ->where('is_active', 1)->orderBy('id', 'asc')->get();
        
        $secs = array();
        $secs[] = array('0' => 'select a section');

        foreach ($sections as $section) {
            $secs[] = array(
                $section->id  => $section->name.'('.$section->edtype->code.')'
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

    public function get_all_sections_with_type( $sectioninfo_id )
    {
        $sectioninfos = (new SectionInfo)->fetch($sectioninfo_id);
        $sections = self::where('education_type_id', $sectioninfos->education_type_id)->where('is_active', 1)->orderBy('id', 'asc')->get();
        
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

    public function get_column_via_identifier($column, $id)
    {
        return self::where('id', $id)->first()->$column;
    }

    public function get_all_sections_bytype($type)
    {
        $sections = self::where('is_active', 1)->where('education_type_id', $type)
        ->whereNotIn('id',function($query) {
            $query->select('section_id')->from('sections_info');
        })->orderBy('id', 'asc')->get();
        

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
    
    public function get_all_sections_bylevel($level, $type)
    {
        $sections = self::where('is_active', 1)->where('level_id', $level)->where('education_type_id', $type)
        ->whereNotIn('id',function($query) {
            $query->select('section_id')->from('sections_info');
        })->orderBy('id', 'asc')->get();
        

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

    public function edtype()
    {
        return $this->belongsTo('App\Models\EducationType', 'education_type_id', 'id');
    }
}
