<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_quantity',
        'vat_type',
        'item_subtotal',
        'item_discount_amount',
        'discount',
        'item_quantity',
        'transactions_id',
        'item_id',
    ];

    public function transactionJoin()
    {
        return $this->belongsTo(TransactionDetails::class, 'transaction_id');
    }

    public function itemJoin()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
