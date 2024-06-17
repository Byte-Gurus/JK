<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_type'
    ];
    public function usersJoin()
    {
        return $this->hasMany(User::class, 'status_id');
    }

}
