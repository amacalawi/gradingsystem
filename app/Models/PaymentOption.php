<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentOption extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'payment_options';
    
    public $timestamps = false;
}

