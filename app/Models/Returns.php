<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'return_number',
        'return_total_amount',
        'original_amount',
        'return_vat_amount',
        'refund_amount',
        'exchange_amount',
        'hasTransaction',
        'returnedBy',
        'approvedBy'
    ];

    public function transactionJoin()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function returnDetailsJoin()
    {
        return $this->hasMany(ReturnDetails::class, 'returns_id');
    }
    public function userJoin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);
        $value = trim($value);

        return $query->where(function ($query) use ($value) {
            $query->whereRaw('LOWER(return_number) LIKE ?', ["%{$value}%"])
                ->orWhereHas('transactionJoin', function ($query) use ($value) {
                    $query->whereRaw('LOWER(transaction_number) LIKE ?', ["%{$value}%"]);
                });
        });
    }

}
