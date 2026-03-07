<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'order_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'description',
    ];

    /**
     * علاقة الحركة بالمحفظة: كل حركة تنتمي لمحفظة واحدة
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * علاقة الحركة بالطلب: الحركة قد ترتبط بطلب معين (في حالة الإيداع)
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Scopes: دوال مساعدة لتسهيل جلب البيانات في الـ Blade والـ Controller
     */
    
    // لجلب الإيداعات فقط
    public function scopeDeposits($query)
    {
        return $query->where('type', 'deposit');
    }

    // لجلب السحوبات فقط
    public function scopeWithdrawals($query)
    {
        return $query->where('type', 'withdraw');
    }
}
