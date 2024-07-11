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
        'maximum_stock_ratio',
        'redorder_point',
        'vat_amount',
        'vat_id',
        'status'
    ];
}
