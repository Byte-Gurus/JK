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
        'item_unit',
        'item_category',
        'item_description',
        'maximum_stock_level',
        'bulk_quantity',
        'shelf_life_type',
        'reorder_point',
        'vat_percent',
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

    public function supplierItemsJoin()
    {
        return $this->hasOne(SupplierItems::class, 'item_id');
    }
    public function purchasedetailsJoin()
    {
        return $this->hasMany(PurchaseDetails::class, 'item_id');
    }

    public function backorderJoin()
    {
        return $this->hasMany(BackOrder::class, 'item_id');
    }



    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);
        $value = trim($value);


        return $query->whereRaw('LOWER(item_name) like ?', ["%{$value}%"])
            ->orWhereRaw('LOWER(item_description) like ?', ["%{$value}%"])
            ->orWhereRaw('LOWER(barcode) like ?', ["%{$value}%"]);
    }

}
