<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
use App\Models\SubModule;

class Header extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'headers';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $header = self::find($id);
        if ($header) {
            $results = array(
                'id' => ($header->id) ? $header->id : '',
                'code' => ($header->code) ? $header->code : '',
                'name' => ($header->name) ? $header->name : '',
                'description' => ($header->description) ? $header->description : '',
                'slug' => ($header->slug) ? $header->slug : '',
                'order' => ($header->order) ? $header->order : ''
            );
        } else {
            $results = array(
                'id' => '',
                'code' => '',
                'name' => '',
                'description' => '',
                'slug' => '',
                'order' => ''
            );
        }
        return (object) $results;
    }

    public function all_headers()
    {	
    	$headers = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $headerx = array();
        $headerx[] = array('' => 'select a header');
        foreach ($headers as $header) {
            $headerx[] = array(
                $header->id => $header->name
            );
        }

        $headers = array();
        foreach($headerx as $desig) {
            foreach($desig as $key => $val) {
                $headers[$key] = $val;
            }
        }

        return $headers;
    }

    public function all_modules()
    {
        $headers = self::where('is_active', 1)->orderBy('order', 'asc')->get();
        $increment = 0;
        $headerx = array();
        foreach ($headers as $header) {

            $headerx[$increment] = array(
                'id' => $header->id,
                'name' => $header->name,
                'slug' => $header->slug,
            );

            $modules = Module::where([
                'header_id' => $header->id,
                'is_active' => 1
            ])->orderBy('order', 'asc')->get();

            foreach ($modules as $module) {

                $headerx[$increment]['modules'][$module->id] = array(
                    'id' => $module->id,
                    'name' => $module->name,
                    'slug' => $module->slug,
                    'icon' => $module->icon
                );

                $sub_modules = SubModule::where([
                    'module_id' => $module->id,
                    'is_active' => 1
                ])->orderBy('order', 'asc')->get();

                foreach ($sub_modules as $sub_module) {
                    $headerx[$increment]['sub_modules'][$module->id][$sub_module->id] = array(
                        'id' => $sub_module->id,
                        'name' => $sub_module->name,
                        'slug' => $sub_module->slug,
                        'icon' => $sub_module->icon
                    );
                }
            }

            $increment++;
        }

        return $headerx;
    }
}

