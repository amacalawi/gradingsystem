<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTerm extends Model
{	
    protected $guarded = ['id'];

    protected $table = 'payment_terms';
    
    public $timestamps = false;
}

