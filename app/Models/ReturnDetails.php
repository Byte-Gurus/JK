<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_quantity',
        'item_return_amount',
        'description',
        'return_id',
        'transaction_details_id'

    ];

    public function returnJoin()
    {
        return $this->belongsTo(Returns::class, 'return_id');
    }

    public function transactionDetailsJoin()
    {
        return $this->belongsTo(TransactionDetails::class, 'transaction_details_id');
    }

}
