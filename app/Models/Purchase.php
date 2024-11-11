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
        'user_id',
    ];

    public function supplierJoin()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function userJoin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function backorderJoin()
    {
        return $this->hasMany(BackOrder::class, 'purchase_id');
    }
    public function purchaseDetailsJoin()
    {
        return $this->hasMany(PurchaseDetails::class, 'purchase_id');
    }
    public function deliveryJoin()
    {
        return $this->hasOne(Delivery::class, 'purchase_id');
    }
    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);

        return $query->whereRaw('LOWER(po_number) like ?', ["%{$value}%"])
            ->orWhereHas('purchaseDetailsJoin.itemsJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(item_name) LIKE ?', ["%{$value}%"]);
            });
    }
}
