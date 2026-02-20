<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBankAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'bank_name',
        'iban',
        'account_holder_name',
        'account_number',
        'status',
        'verified_at',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function withdrawRequests()
{
    return $this->hasMany(WithdrawRequest::class, 'bank_account_id');
}

}
