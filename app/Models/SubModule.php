<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubModule extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'sub_modules';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $submodule = self::find($id);
        if ($submodule) {
            $results = array(
                'id' => ($submodule->id) ? $submodule->id : '',
                'module_id' => ($submodule->module_id) ? $submodule->module_id : '',
                'code' => ($submodule->code) ? $submodule->code : '',
                'name' => ($submodule->name) ? $submodule->name : '',
                'description' => ($submodule->description) ? $submodule->description : '',
                'icon' => ($submodule->icon) ? $submodule->icon : '',
                'slug' => ($submodule->slug) ? $submodule->slug : '',
                'order' => ($submodule->order) ? $submodule->order : ''
            );
        } else {
            $results = array(
                'id' => '',
                'module_id' => '',
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

    public function all_submodules()
    {	
    	$submodules = self::where('is_active', 1)->orderBy('order', 'asc')->get();

        $submodules = array();
        $submodules[] = array('' => 'select a sub module');
        foreach ($submodules as $submodule) {
            $submodules[] = array(
                $submodule->id => $submodule->name
            );
        }

        $submodules = array();
        foreach($submodules as $desig) {
            foreach($desig as $key => $val) {
                $submodules[$key] = $val;
            }
        }

        return $submodules;
    }

    public function module()
    {
        return $this->belongsTo('App\Models\Module');
    }
}

