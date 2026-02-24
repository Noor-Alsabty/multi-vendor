<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorsRequest extends Model
{
    protected $table = 'vendors-requests';
    use HasFactory;
    protected $fillable = [
        'user_id',
        'store_name',
        'store_email',
        'store_phone',
        'store_logo',
        'description',
        'status',
        'verification_reject_reason',
        'verification_date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
