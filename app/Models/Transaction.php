<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_number',
        'transaction_type',
        'subtotal',
        'discount_id',
        'total_amount',
        'total_vat_amount',
        'total_discount_amount',
        'excess_amount',
        'customer_id',
        'user_id'
    ];

    public function customerJoin()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function discountJoin()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
    public function paymentJoin()
    {
        return $this->hasOne(Payment::class, 'transaction_id');
    }


    public function userJoin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactionDetailsJoin()
    {
        return $this->hasMany(TransactionDetails::class, 'transaction_id');
    }
    public function returnJoin()
    {
        return $this->hasOne(Returns::class, 'transaction_id');
    }

    public function voidTransactionJoin()
    {
        return $this->hasOne(VoidTransaction::class, 'transaction_id');
    }

    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);
        $value = trim($value);

        return $query->whereRaw('LOWER(transaction_number) like ?', ["%{$value}%"])
            ->orWhereHas('customerJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(firstname) like ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(middlename) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(lastname) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(CONCAT(firstname, " ", lastname)) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(CONCAT(firstname, " ", middlename, " ", lastname)) LIKE ?', ["%{$value}%"]);
            })
            ->orWhereHas('userJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(firstname) like ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(middlename) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(lastname) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(CONCAT(firstname, " ", lastname)) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(CONCAT(firstname, " ", middlename, " ", lastname)) LIKE ?', ["%{$value}%"]);
            })
            ->orWhereHas('discountJoin', function ($query) use ($value) {
                // Check the database connection driver and use the appropriate CAST syntax
                $dbDriver = config('database.default');
                if ($dbDriver == 'pgsql') {
                    $query->whereRaw('LOWER(CAST(percentage AS TEXT)) like ?', ["%{$value}%"]);
                } else {
                    // Assume MySQL or other compatible database
                    $query->whereRaw('LOWER(CAST(percentage AS CHAR)) like ?', ["%{$value}%"]);
                }
            })
            ->orWhereHas('paymentJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(payment_type) like ?', ["%{$value}%"]);
            });

    }
}
