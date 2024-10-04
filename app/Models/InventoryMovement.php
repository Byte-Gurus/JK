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
        'transaction_detail_id',
        'void_transaction_id',
    ];

    public function inventoryJoin()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
    public function voidTransactionJoin()
    {
        return $this->belongsTo(VoidTransaction::class, 'void_transaction_id');
    }

    public function adjustmentJoin()
    {
        return $this->belongsTo(InventoryAdjustment::class, 'inventory_adjustment_id');
    }

    public function transactionDetailsJoin()
    {
        return $this->belongsTo(TransactionDetails::class, 'transaction_detail_id');
    }


    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);

        return $query->whereHas('inventoryJoin.itemJoin', function ($query) use ($value) {
            $query->whereRaw('LOWER(item_name) LIKE ?', ["%{$value}%"])
                ->orWhereRaw('LOWER(barcode) LIKE ?', ["%{$value}%"]);
        })
            ->orWhereHas('adjustmentJoin.inventoryJoin.itemJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(item_name) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(barcode) LIKE ?', ["%{$value}%"]);
            })
            ->orWhereHas('transactionDetailsJoin.inventoryJoin.itemJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(item_name) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(barcode) LIKE ?', ["%{$value}%"]);
            })
            ->orWhereHas('voidTransactionJoin.transactionJoin.transactionDetailsJoin.inventoryJoin.itemJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(item_name) LIKE ?', ["%{$value}%"])
                    ->orWhereRaw('LOWER(barcode) LIKE ?', ["%{$value}%"]);
            });
    }
}
