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
        'reorder_percentage',
        'reorder_point',
        'vat_amount',
        'vat_type',
        'status_id'
    ];


    public function inventoryJoin()
    {
        return $this->hasMany(Inventory::class, 'item_id');
    }

    public function statusJoin()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function purchasedetailsJoin()
    {
        return $this->hasMany(PurchaseDetails::class, 'item_id');
    }


    public function scopeSearch($query, $value)  //* search function
    {
        //? queries
        $query->where('item_name', 'like', "%{$value}%")
        ->orWhere('barcode', 'like', "%{$value}%");

    }
}
