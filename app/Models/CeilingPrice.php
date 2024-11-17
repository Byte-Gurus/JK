<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CeilingPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'ceiling_price',
        'item_id'
    ];

    public function itemJoin()
    {
        return $this->hasOne(Item::class, 'item_id');
    }
}
