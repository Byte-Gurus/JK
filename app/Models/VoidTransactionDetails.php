<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoidTransactionDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'void_quantity',
        'item_void_amount',
        'reason',
        'void_transaction_id',
        'transaction_details_id'
    ];

    public function voidTransactionJoin()
    {
        return $this->belongsTo(VoidTransaction::class, 'void_transaction_id');
    }
    public function transactionDetailsJoin()
    {
        return $this->belongsTo(TransactionDetails::class, 'transaction_details_id');
    }

    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);

        return $query->whereHas('voidTransactionJoin', function ($query) use ($value) {
            $query->whereRaw('LOWER(void_number) LIKE ?', ["%{$value}%"]);
        })
            ->orWhereHas('transactionDetailsJoin.transactionJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(transaction_number) LIKE ?', ["%{$value}%"]);
            });
    }
}
