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
        'item_description',
        'maximum_stock_ratio',
        'reorder_point',
        'vat_amount',
        'vat_id',
        'status_id'
    ];

    public function vatJoin()
    {
        return $this->belongsTo(Vat::class, 'vat_id');
    }
    public function statusJoin()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function scopeSearch($query, $value)  //* search function
    {
        //? queries
        $query->where('item_name', 'like', "%{$value}%")
            ->orWhere('item_description', 'like', "%{$value}%");

    }
}
