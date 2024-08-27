<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $casts = [
        'stock_in_date' => 'datetime',
        'expiration_date' => 'datetime',
    ];

    protected $fillable = [
        'sku_code',
        'cost',
        'mark_up_price',
        'selling_price',
        'current_stock_quantity',
        'stock_in_date',
        'stock_in_quantity',
        'expiration_date',
        'status',
        'item_id',
        'delivery_id',
        'user_id'
    ];

    public function itemJoin()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function deliveryJoin()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }
    public function userJoin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function scopeSearch($query, $value)
    {

        return $query->where('sku_code', 'like', "%{$value}%")
            ->orWhereHas('itemJoin', function ($query) use ($value) {
                $query->where('item_name', 'like', "%{$value}%")
                    ->orWhere('barcode', 'like', "%{$value}%");
            })
            ->orWhereHas('deliveryJoin.purchaseJoin.supplierJoin', function ($query) use ($value) {
                $query->where('company_name', 'like', "%{$value}%");
            });
    }
}
