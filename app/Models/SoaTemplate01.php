<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoaTemplate01 extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'soa_template_01';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $template = self::find($id);
        if ($template) {
            $results = array(
                'id' => ($template->id) ? $template->id : '',
                'identification_no' => ($template->identification_no) ? $template->identification_no : '',
                'firstname' => ($template->firstname) ? $template->firstname : '',
                'middlename' => ($template->middlename) ? $template->middlename : '',
                'lastname' => ($template->lastname) ? $template->lastname : '',
                'outstanding_balance' => ($template->outstanding_balance) ? $template->outstanding_balance : '',
                'billing_period' => ($template->billing_period) ? $template->billing_period : '',
                'billing_due_date' => ($template->billing_due_date) ? date('Y-m-d', strtotime($template->billing_due_date)) : '',
            );
        } else {
            $results = array(
                'id' => '',
                'identification_no' => '',
                'firstname' => '',
                'middlename' => '',
                'lastname' => '',
                'outstanding_balance' => '',
                'billing_period' => '',
                'billing_due_date' => ''
            );
        }
        return (object) $results;
    }

    public function lookup($identification_no, $column)
    {   
        $message = '';

        $query = self::where('identification_no', $identification_no)->get();
        if ($query->count() > 0) {
            $message = $query->first()->$column;
        } 

        if ($message == '' && $column == 'outstanding_balance') {
            return 'PHP 0.00';
        } else if ($message != '' && $column == 'outstanding_balance') {
            return 'PHP '. number_format($message, 2);
        }

        return $message;
    }
}

