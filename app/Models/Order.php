<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

 protected $fillable = [
        'customer_id',
        'shipping_method_id',
        'coupon_id',
        'total_amount',
        'status',
        'payment_status',
        'shipped_at',
    ];

    // Customer (User)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    
    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

   
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }


public function items()
{
    return $this->hasMany(OrderItem::class);
}


public function payments()
{
    return $this->hasMany(Payment::class);
}


public function shippments()
{
    return $this->hasMany(Shippment::class);
}



}
