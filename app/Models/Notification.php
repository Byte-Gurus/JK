<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'inventory_id',
        'credit_id',
    ];

    public function inventoryJoin()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
    public function creditJoin()
    {
        return $this->belongsTo(Credit::class, 'credit_id');
    }

}
