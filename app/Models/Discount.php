<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'percentage'
    ];

    public function purchaseDetailsJoin()
    {
        return $this->hasMany(PurchaseDetails::class, 'discount_id');
    }
}
