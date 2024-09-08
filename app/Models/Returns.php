<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'return_total_amount'
    ];

    public function transactionJoin()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function returnDetailsJoin()
    {
        return $this->hasMany(ReturnDetails::class, 'returns_id');
    }

}
