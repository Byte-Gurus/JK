<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'item_name',
        'description',
        'maximum_stock_level',
        'redorder_point',
        'vat_amount',
        'vat_id'
    ];
}
