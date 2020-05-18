<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $guarded = ['id'];

    protected $table = 'admissions';
    
    public $timestamps = false;

    public function all_admitted_student()
    {
        $admitted = self::where('is_active', 1)->where('status', 'admit')->where('schoolyear_id', '1')->orderBy('lastname', 'asc')->get();
        return $admitted;
    }

    public function get_this_admitted( $id )
    {
        $admitted = self::where('is_active', 1)->where('status', 'admit')->where('user_id', $id)->where('schoolyear_id', '1')->orderBy('lastname', 'asc')->get();
        return $admitted;
    }
    
}
