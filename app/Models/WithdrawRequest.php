<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
        protected $fillable = [
        'bank_account_id',
        'amount',
        'status',
        'processed_at',
    ];

    public function bankAccount()
    {
        return $this->belongsTo(VendorBankAccount::class, 'bank_account_id');
    }

}
