<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_number',
        'transaction_type',
        'subtotal',
        'discount_id',
        'total_amount',
        'total_vat_amount',
        'total_discount_amount',
        'customer_id',  
        'user_id'
    ];

    public function customerJoin()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function discountJoin()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
    public function paymentJoin()
    {
        return $this->hasOne(Payment::class, 'transaction_id');
    }


    public function userJoin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactionDetailsJoin()
    {
        return $this->hasMany(TransactionDetails::class, 'transaction_id');
    }

    public function scopeSearch($query, $value)
    {

        return $query->where('transaction_number', 'like', "%{$value}%")
            ->orWhereHas('customerJoin', function ($query) use ($value) {
                $query->where('firstname', 'like', "%{$value}%");
            })
            ->orWhereHas('userJoin', function ($query) use ($value) {
                $query->where('firstname', 'like', "%{$value}%");
            })
            ->orWhereHas('discountJoin', function ($query) use ($value) {
                $query->where('percentage', 'like', "%{$value}%");
            })
            ->orWhereHas('paymentJoin', function ($query) use ($value) {
                $query->where('payment_type', 'like', "%{$value}%");
            });
    }
}
