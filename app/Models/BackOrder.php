<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'status',
    ];

    public function purchaseJoin()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

}
