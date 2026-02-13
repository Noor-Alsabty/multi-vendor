<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
protected $fillable = [
        'user_id',
    ];

    // العلاقة مع User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع CartItems
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }







}
