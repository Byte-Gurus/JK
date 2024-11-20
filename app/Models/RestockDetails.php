<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestockDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost',
        'restock_quantity',
        'expiration_date',
        'item_id',
        'delivery_id',
        'sku_code',
        'bacorder_quantity'
    ];

    public function itemJoin()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function deliveryJoin()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

}
