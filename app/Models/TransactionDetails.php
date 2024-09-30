<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_quantity',
        'vat_type',
        'status',
        'item_subtotal',
        'item_discount_amount',
        'discount_id',
        'item_price',
        'item_vat_percent',
        'transaction_id',
        'item_id',
        'inventory_id',
    ];

    public function transactionJoin()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function inventoryJoin()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function itemJoin()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function discountJoin()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

}
