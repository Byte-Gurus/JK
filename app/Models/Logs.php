<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message',
        'action',
    ];
    public function usersJoin()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
