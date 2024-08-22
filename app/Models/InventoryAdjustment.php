<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAdjustment extends Model
{
    use HasFactory;


    protected $fillable = [
        'reason',
        'operation',
        'adjusted_quantity',
        'inventory_id',
        'user_id'

    ];

    public function inventoryJoin()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function userJoin()
    {
        return $this->belongsTo(User::class, 'inventory_id');
    }

    public function scopeSearch($query, $value)
    {

        return $query->where('reason', 'like', "%{$value}%");
    }

}
