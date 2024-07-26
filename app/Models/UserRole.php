<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
    ];

    public function usersJoin()
    {
        return $this->hasMany(User::class, 'user_role_id');
    }
}
