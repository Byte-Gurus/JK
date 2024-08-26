<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'movement_type',
        'inventory_id',
        'operation',
        'inventory_adjustment_id',

    ];

    public function inventoryJoin()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function adjustmentJoin()
    {
        return $this->belongsTo(InventoryAdjustment::class, 'inventory_adjustment_id');
    }
}
