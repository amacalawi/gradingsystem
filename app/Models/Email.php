<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $guarded = ['id'];

    protected $table = 'emails';
    
    public $timestamps = false;

    public function all_email()
    {	
    	$emails = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $emls = array();
        $emls[] = array('' => 'select a sender');
        foreach ($emails as $email) {
            $emls[] = array(
                $email->id => $email->username.' ('.$email->email.')'
            );
        }

        $emails = array();
        foreach($emls as $eml) {
            foreach($eml as $key => $val) {
                $emails[$key] = $val;
            }
        }

        return $emails;
    }

}
