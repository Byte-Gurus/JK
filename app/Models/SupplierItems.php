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

    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);
        $value = trim($value);

        return $query->whereHas('itemjoin', function ($query) use ($value) {
            $query->whereRaw('LOWER(item_name) LIKE ?', ["%{$value}%"])
                ->orWhereRaw('LOWER(item_description) LIKE ?', ["%{$value}%"]);

        });
    }
}
