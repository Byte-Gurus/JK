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

    public function paymentJoin()
    {
        return $this->belongsTo(Payment::class, 'transaction_id');
    }

    public function userJoin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactionDetailsJoin()
    {
        return $this->hasMany(TransactionDetails::class, 'transaction_id');
    }
}
