<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //

    protected $fillable = [
        'order_id',
        'card_number_masked',
        'card_holder_name',
        'amount',
        'status',
        'payment_date',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}


















