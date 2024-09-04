<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'credit_number',
        'due_date',
        'credit_amount',
        'credit_limit',
        'transaction_id',
        'customer_id',
    ];

    public function customerJoin()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function transactionJoin()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function scopeSearch($query, $value)
    {

        return $query->whereHas('transactionJoin', function ($query) use ($value) {
            $query->where('transaction_number', 'like', "%{$value}%");
        })
            ->orWhereHas('customerJoin', function ($query) use ($value) {
                $query->where('firstname', 'like', "%{$value}%");
            });
    }
}
