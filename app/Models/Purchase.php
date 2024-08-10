<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'supplier_id',
    ];

    public function supplierJoin()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }


    public function scopeSearch($query, $value)  //* search function
    {
        //? queries
        $query->where('po_number', 'like', "%{$value}%");
    }
}
