<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_cost',
        'item_id',
        'supplier_id',

    ];


    public function supplierJoin()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function itemjoin()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
