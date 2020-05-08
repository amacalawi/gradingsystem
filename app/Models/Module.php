<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'modules';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $module = self::find($id);
        if ($module) {
            $results = array(
                'id' => ($module->id) ? $module->id : '',
                'header_id' => ($module->header_id) ? $module->header_id : '',
                'code' => ($module->code) ? $module->code : '',
                'name' => ($module->name) ? $module->name : '',
                'description' => ($module->description) ? $module->description : '',
                'icon' => ($module->icon) ? $module->icon : '',
                'slug' => ($module->slug) ? $module->slug : '',
                'order' => ($module->order) ? $module->order : ''
            );
        } else {
            $results = array(
                'id' => '',
                'header_id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'icon' => '',
                'slug' => '',
                'order' => ''
            );
        }
        return (object) $results;
    }

    public function all_modules()
    {	
    	$modules = self::where('is_active', 1)->orderBy('order', 'asc')->get();

        $modulex = array();
        $modulex[] = array('' => 'select a module');
        foreach ($modules as $module) {
            $modulex[] = array(
                $module->id => $module->name
            );
        }

        $modules = array();
        foreach($modulex as $module) {
            foreach($module as $key => $val) {
                $modules[$key] = $val;
            }
        }

        return $modules;
    }

    public function header()
    {
        return $this->belongsTo('App\Models\Header');
    }
}

