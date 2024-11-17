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
        'old_po_id',
        'receipt_picture',
        'receipt_number'
    ];

    public function purchaseJoin()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function backorderJoin()
    {
        return $this->hasMany(BackOrder::class, 'delivery_id');
    }


    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);

        return $query->whereHas('purchaseJoin', function ($query) use ($value) {
            $query->whereRaw('LOWER(po_number) LIKE ?', ["%{$value}%"]);
        });
    }

}
