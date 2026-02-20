<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorDocument extends Model
{
use HasFactory;
    protected $fillable = [
        'vendor_id',
        'document_type',
        'document_path',
        'document_number',
        'status',
        'rejection_reason',
        'uploaded_at',
        'verified_at',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
