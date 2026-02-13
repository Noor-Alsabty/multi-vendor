<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    //

    protected $fillable = [
        'name',
        'description',
    ];

    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }








}
