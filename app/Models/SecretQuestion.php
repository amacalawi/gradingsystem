<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecretQuestion extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'secret_questions';
    
    public $timestamps = false;

    public function all_secrets()
    {	
    	$secrets = self::where('is_active', 1)->orderBy('id', 'asc')->get();

        $secretx = array();
        $secretx[] = array('' => 'select a secret question');
        foreach ($secrets as $secret) {
            $secretx[] = array(
                $secret->id => $secret->name
            );
        }

        $secrets = array();
        foreach($secretx as $desig) {
            foreach($desig as $key => $val) {
                $secrets[$key] = $val;
            }
        }

        return $secrets;
    }
}

