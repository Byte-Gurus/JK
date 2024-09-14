<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'birthdate',
        'contact_number',
        'customer_type',
        'customer_discount_no',
        'id_picture',
        'address_id',
    ];

    public function addressJoin()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function creditJoin()
    {
        return $this->hasOne(Credit::class, 'customer_id');
    }
    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);

        return $query->whereRaw('LOWER(firstname) LIKE ?', ["%{$value}%"])
            ->orWhereRaw('LOWER(middlename) LIKE ?', ["%{$value}%"])
            ->orWhereRaw('LOWER(lastname) LIKE ?', ["%{$value}%"])
            ->orWhereRaw('LOWER(customer_discount_no) LIKE ?', ["%{$value}%"])
            ->orWhereHas('addressJoin', function ($query) use ($value) {
                $query->whereRaw('LOWER(street) LIKE ?', ["%{$value}%"])
                    ->orWhereHas('provinceJoin', function ($query) use ($value) {
                        $query->whereRaw('LOWER(province_description) LIKE ?', ["%{$value}%"]);
                    })
                    ->orWhereHas('cityJoin', function ($query) use ($value) {
                        $query->whereRaw('LOWER(city_municipality_description) LIKE ?', ["%{$value}%"]);
                    })
                    ->orWhereHas('barangayJoin', function ($query) use ($value) {
                        $query->whereRaw('LOWER(barangay_description) LIKE ?', ["%{$value}%"]);
                    });
            });
    }
}
