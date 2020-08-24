<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Outbox;

class Message extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'messages';
    
    public $timestamps = false;

    private static function SEND_URL() {
        return "http://localhost:13013/cgi-bin/sendsms?username=foo&password=bar&dlr-mask=24";
    }

    private static function DLR_URL()
    {   
        return 'http://'.$_SERVER['SERVER_NAME'].'/notifications/messaging/infoblast/dlr?type=%d&answer=%A';
    }
    
    public function sendItem($id, $msisdn, $smsc, $body, $groups=null)
    {
        $dlr = self::DLR_URL() . '&outbox_id=' . $id;
        $url = self::SEND_URL() . '&to=' . $msisdn . '&text=' . urlencode($body) . '&smsc=' . $smsc . '&dlr-url=' . urlencode($dlr);

        $ch = curl_init ($url);
        ob_start();
        curl_exec($ch);
        $str = ob_get_contents();
        ob_end_clean();
        curl_close ($ch);

        $outbox = Outbox::find($id);

        if(!$outbox) {
            throw new NotFoundHttpException();
        }

        $outbox->extra = $str;
        $outbox->update();
        return true;
    }
}

