<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku_code',
        'cost',
        'mark_up_price',
        'selling_price',
        'quantity',
        'expiration_date',
        'stock_in_date',
        'status',
        'item_id',
        'supplier_id',

    ];
}
