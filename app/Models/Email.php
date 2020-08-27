<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $guarded = ['id'];

    protected $table = 'emails';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $email = self::find($id);
        if ($email) {
            $results = array(
                'id' => ($email->id) ? $email->id : '',
                'username' => ($email->username) ? $email->username : '',
                'email' => ($email->email) ? $email->email : '',
                'password' => ($email->password) ? $email->password : '',
            );
        } else {
            $results = array(
                'id' => '',
                'username' => '',
                'email' => '',
                'password' => '',
            );
        }
        return (object) $results;
    }

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
