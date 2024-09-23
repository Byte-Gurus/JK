<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'movement_type',
        'transaction_id',
        'credit_id',
        'returns_id',

    ];

    public function transactionJoin()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function creditJoin()
    {
        return $this->belongsTo(Credit::class, 'credit_id');
    }

    public function returnsJoin()
    {
        return $this->belongsTo(Returns::class, 'returns_id');
    }

    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);

        return $query->whereRaw('LOWER(transaction_number) like ?', ["%{$value}%"])
            ->orWhereHas('transactionJoin.customerJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(firstname) like ?', ["%{$value}%"]);
            })
            ->orWhereHas('transactionJoin.userJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(firstname) like ?', ["%{$value}%"]);
            })
            ->orWhereHas('transactionJoin.discountJoin', function ($query) use ($value) {
                // Cast percentage to text if it's a numeric field
                $query->whereRaw('LOWER(CAST(percentage AS TEXT)) like ?', ["%{$value}%"]);
            })
            ->orWhereHas('transactionJoin.paymentJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(payment_type) like ?', ["%{$value}%"]);
            })
            ->orWhereHas('creditJoin.customerJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(firstname) LIKE ?', ["%{$value}%"]);
            });
    }
}
