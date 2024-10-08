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

    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);

        return $query->whereRaw('LOWER(void_number) LIKE ?', ["%{$value}%"])
            ->orWhereHas('transactionJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(transaction_number) LIKE ?', ["%{$value}%"]);
            });
    }

}
