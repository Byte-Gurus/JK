<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoidTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'void_number',
        'void_total_amount',
        'original_amount',
        'void_vat_amount',
        'hasTransaction',
        'user_id',
    ];

    public function voidTransactionDetailsJoin()
    {
        return $this->hasMany(VoidTransactionDetails::class, 'void_transaction_id');
    }
    public function transactionJoin()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
