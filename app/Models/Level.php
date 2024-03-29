<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $guarded = ['id'];

    protected $table = 'levels';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $level = self::find($id);
        if ($level) {
            $results = array(
                'id' => ($level->id) ? $level->id : '',
                'code' => ($level->code) ? $level->code : '',
                'name' => ($level->name) ? $level->name : '',
                'description' => ($level->description) ? $level->description : '',
                'education_type_id' => ($level->education_type_id) ? $level->education_type_id : '',
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'education_type_id' => ''
            );
        }
        return (object) $results;
    }

    public function get_all_levels_with_empty() // all levels with empty value
    {	
    	$levels = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $lvls = array();
        $lvls[] = array('' => 'please select a grade level');
        
        foreach ($levels as $level) {
            $lvls[] = array(
                $level->id => $level->name
            );
        }

        $levels = array();
        foreach($lvls as $lvl) {
            foreach($lvl as $key => $val) {
                $levels[$key] = $val;
            }
        }

        return $levels;
    }

    public function get_all_levels() //all_levels original name
    {	
    	$levels = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $lvls = array();
        $lvls[] = array('0' => 'select a level');
        
        foreach ($levels as $level) {
            $lvls[] = array(
                $level->id => $level->name
            );
        }

        $levels = array();
        foreach($lvls as $lvl) {
            foreach($lvl as $key => $val) {
                $levels[$key] = $val;
            }
        }

        return $levels;
    }
    
    public function get_all_levels_type() //all_levels original name
    {	
        $levels = self::with([
            'edtype' => function($q) { 
                $q->select(['id', 'code', 'name']); 
            }
        ])
        ->where('is_active', 1)->orderBy('id', 'asc')->get();

        $lvls = array();
        $lvls[] = array('0' => 'select a level');
        
        foreach ($levels as $level) {
            $lvls[] = array(
                $level->id => $level->name.'('.$level->edtype->code.')'
            );
        }

        $levels = array();
        foreach($lvls as $lvl) {
            foreach($lvl as $key => $val) {
                $levels[$key] = $val;
            }
        }

        return $levels;
    }

    public function get_all_levels_with_type( $sectioninfo_id )
    {
        $sectioninfos = (new SectionInfo)->fetch($sectioninfo_id);
    	$levels = self::where('education_type_id', $sectioninfos->education_type_id)->where('is_active', 1)->orderBy('id', 'asc')->get();

        $lvls = array();
        $lvls[] = array('0' => 'select a level');
        
        foreach ($levels as $level) {
            $lvls[] = array(
                $level->id => $level->name
            );
        }

        $levels = array();
        foreach($lvls as $lvl) {
            foreach($lvl as $key => $val) {
                $levels[$key] = $val;
            }
        }

        return $levels;
    }

    public function get_all_levels_bytype($type)
    {
        $levels = self::where('is_active', 1)->where('education_type_id', $type)->orderBy('id', 'asc')->get();

        $lvls = array();
        $lvls[] = array('0' => 'select a level');

        foreach ($levels as $level) {
            $lvls[] = array(
                $level->id  => $level->name,
            );
        }

        $levels = array();
        foreach($lvls as $lvl) {
            foreach($lvl as $key => $val) {
                $levels[$key] = $val;
            }
        }   

        return $levels;  
    }

    public function all_levels_via_type($type)
    {
        $levels = self::select(['id', 'code', 'name', 'description'])
        ->where([
            'education_type_id' => $type,
            'is_active' => 1
        ])
        ->orderBy('id', 'asc')
        ->get();
        
        return $levels->map(function($levelx) {
            return (object) [
                'id' => $levelx->id,
                'code' => $levelx->code,
                'name' => $levelx->name,
                'description' => $levelx->description
            ];
        });
    }

    public function edtype()
    {
        return $this->belongsTo('App\Models\EducationType', 'education_type_id', 'id');
    }
}
