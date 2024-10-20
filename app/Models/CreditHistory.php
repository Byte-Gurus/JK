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
        'credit_amount',
        'remaining_balance',
        'payment_id'
    ];

    public function paymentJoin()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
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
                ->orWhereHas('creditJoin.customerJoin', function ($query) use ($value) {
                    $query->whereRaw('LOWER(firstname) LIKE ?', ["%{$value}%"])
                        ->orWhereRaw('LOWER(middlename) LIKE ?', ["%{$value}%"])
                        ->orWhereRaw('LOWER(lastname) LIKE ?', ["%{$value}%"])
                        ->orWhereRaw('LOWER(CONCAT(firstname, \' \', lastname)) LIKE ?', ["%{$value}%"])
                        ->orWhereRaw('LOWER(CONCAT(firstname, \' \', middlename, \' \', lastname)) LIKE ?', ["%{$value}%"]);
                });
        });
    }
}
