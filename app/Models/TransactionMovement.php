<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionMovement extends Model
{
    use HasFactory;


    protected $fillable = [
        'transaction_type',
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
}
