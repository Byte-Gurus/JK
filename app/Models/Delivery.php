<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'status',
        'date_delivered',
        'purchase_id',
    ];

    public function purchaseJoin()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function scopeSearch($query, $value)  //* search function
    {
        //? queries
        $query->whereHas('purchaseJoin', function ($query) use ($value) {
            $query->where('po_number', 'like', "%{$value}%");
        });
    }
}
