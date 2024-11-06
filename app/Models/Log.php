<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message',
        'action',
    ];

    public function userJoin()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
