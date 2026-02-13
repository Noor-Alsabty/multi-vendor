<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{


protected $fillable = [
        'user_id',
        'store_name',
        'store_email',
        'store_phone',
        'store_logo',
        'description',
        'verification_status',
        'verification_reject_reason',
        'verification_date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function bankAccounts()
    {
        return $this->hasMany(VendorBankAccount::class);
    }

public function wallet()
{
    return $this->hasOne(Wallet::class);
}

public function documents()
{
    return $this->hasMany(VendorDocument::class);
}



}
