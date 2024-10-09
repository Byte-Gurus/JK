<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'credit_number',
        'due_date',
        'credit_amount',
        'remaining_balance',
        'credit_limit',
        'transaction_id',
        'customer_id',
        'user_id'
    ];

    public function customerJoin()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function userJoin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactionJoin()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);
        $value = trim($value);


        return $query->whereRaw('LOWER(credit_number) LIKE ?', ["%{$value}%"])
            ->orWhereHas('customerJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(firstname) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(middlename) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(lastname) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(CONCAT(firstname, " ", lastname)) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(CONCAT(firstname, " ", middlename, " ", lastname)) LIKE ?', ["%{$value}%"]);
            });
    }

}
