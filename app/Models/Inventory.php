<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'vat_amount',
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
        $value = strtolower($value);

        return $query->whereRaw('LOWER(sku_code) LIKE ?', ["%{$value}%"])
            ->orWhereHas('itemJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(item_name) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(barcode) LIKE ?', ["%{$value}%"]);
            })
            ->orWhereHas('deliveryJoin.purchaseJoin.supplierJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(company_name) LIKE ?', ["%{$value}%"]);
            });
    }

    //belongsto

}
