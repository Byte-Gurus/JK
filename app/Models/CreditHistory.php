<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'credit_id',
    ];

    public function creditJoin()
    {
        return $this->belongsTo(Credit::class, 'credit_id');
    }

    public function scopeSearch($query, $value)
    {

        return $query->where(function ($query) use ($value) {
            $query->whereHas('creditJoin', function ($query) use ($value) {
                $query->where('credit_number', 'like', "%{$value}%");
            })
                ->orWhereHas('creditJoin.transactionJoin.customerJoin', function ($query) use ($value) {
                    $query->where('firstname', 'like', "%{$value}%");
                });
        });
    }
}
