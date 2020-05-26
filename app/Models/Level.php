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
                'type' => ($level->type) ? $level->type : '',
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'type' => ''
            );
        }
        return (object) $results;
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

    public function get_all_levels_bytype($type)
    {
        $levels = self::where('is_active', 1)->where('type', $type)->orderBy('id', 'asc')->get();

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

}
