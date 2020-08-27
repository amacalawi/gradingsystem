<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailOutbox extends Model
{
    protected $guarded = ['id'];

    protected $table = 'emails_outboxes';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $emailoutbox = self::find($id);
        if ($emailoutbox) {
            $results = array(
                'id' => ($emailoutbox->id) ? $emailoutbox->id : '',
                'email_id' => ($emailoutbox->email_id) ? $emailoutbox->email_id : '',
                'email_recipient' => ($emailoutbox->email_recipient) ? $emailoutbox->email_recipient : '',
                'subject' => ($emailoutbox->subject) ? $emailoutbox->subject : '',
                'message' => ($emailoutbox->message) ? $emailoutbox->message : '',
                'is_soa' => ($emailoutbox->is_soa) ? $emailoutbox->is_soa : '',
                'is_payslip' => ($emailoutbox->is_payslip) ? $emailoutbox->is_payslip : '',
                'is_grade' => ($emailoutbox->is_grade) ? $emailoutbox->is_grade : '',
            );
        } else {
            $results = array(
                'id' => '',
                'email_id' => '',
                'email_recipient' => '',
                'subject' => '',
                'message' => '',
                'is_soa' => '',
                'is_payslip' => '',
                'is_grade' => '',
            );
        }
        return (object) $results;
    }

    public function email()
    {
        return $this->belongsTo('App\Models\Email', 'email_id', 'id');
    }
}
