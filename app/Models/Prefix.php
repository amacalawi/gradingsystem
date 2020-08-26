<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prefix extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'prefixes';
    
    public $timestamps = false;

    public function num_format($msisdn)
    {
        $pattern = array('/i/i','/l/i','/o/i','/[^\d]/','/^(\+63|63)/');
        $replace = array(1,1,0,'','0');
        $msisdn = preg_replace($pattern, $replace, trim($msisdn));
        return $msisdn;
    }

    public function get_network($number)
    {
        $msisdn = $this->num_format($number);
        $prefix = str_split($msisdn,4);

        $result = self::select('network')->where('access', 'like', '%' . $prefix[0] . '%')->get();
        $network = 'auto';

        if($result->count() > 0) {
            foreach ($result as $res) {
                $network = $res->network;
            }
        }

        return $network;
    }
}

