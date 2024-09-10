<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'return_total_amount',
        'original_amount'
    ];

    public function transactionJoin()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function returnDetailsJoin()
    {
        return $this->hasMany(ReturnDetails::class, 'returns_id');
    }

    public function scopeSearch($query, $value)
    {

        return $query->whereHas('transactionJoin', function ($query) use ($value) {
                $query->where('transaction_number', 'like', "%{$value}%");
        });
    }

}