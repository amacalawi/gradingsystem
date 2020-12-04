<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'settings';
    
    public $timestamps = false;

    public function fetch()
    {
        $setting = self::where('is_active', 1)->first();
        if ($setting) {
            $results = array(
                'id' => ($setting->id) ? $setting->id : '',
                'name' => ($setting->name) ? $setting->name : '',
                'location' => ($setting->location) ? $setting->location : '',
                'email' => ($setting->email) ? $setting->email : '',
                'phone' => ($setting->phone) ? $setting->phone : '',
                'fax' => ($setting->fax) ? $setting->fax : '',
                'avatar' => ($setting->avatar) ? $setting->avatar : ''
            );
        } else {
            $results = array(
                'id' => '',
                'name' => '',
                'location' => '',
                'email' => '',
                'phone' => '',
                'fax' => '',
                'avatar' => ''
            );
        }
        return (object) $results;
    }
}

