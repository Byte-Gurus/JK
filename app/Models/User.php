<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'contact_number',
        'user_role_id',
        'status_id',
        'username',
        'password',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }


    //? i join ang user sa ibang tables

    public function roleJoin()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }
    public function statusJoin()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function inventoryJoin()
    {
        return $this->hasMany(UserRole::class, 'user_role_id');
    }
    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);
        $value = trim($value);

        return $query->whereRaw('LOWER(username) LIKE ?', ["%{$value}%"])
            ->orWhereRaw('LOWER(firstname) LIKE ?', ["%{$value}%"])
            ->orWhereRaw('LOWER(middlename) LIKE ?', ["%{$value}%"])
            ->orWhereRaw('LOWER(lastname) LIKE ?', ["%{$value}%"])
            ->orWhereRaw('LOWER(CONCAT(firstname, " ", lastname)) LIKE ?', ["%{$value}%"])
            ->orWhereRaw('LOWER(CONCAT(firstname, " ", middlename, " ", lastname)) LIKE ?', ["%{$value}%"]);
    }
}
