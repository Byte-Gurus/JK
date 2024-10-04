<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoidTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        
        'user_id',
    ];

    public function transactionJoin()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
