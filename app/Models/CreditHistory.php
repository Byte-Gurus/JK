<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'credit_id',
    ];

    public function transactionJoin()
    {
        return $this->belongsTo(Credit::class, 'credit_id');
    }
}
