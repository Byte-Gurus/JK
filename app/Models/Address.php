<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'province_code',
        'city_municipality_code',
        'barangay_code',
    ];

    public function provinceJoin()
    {
        return $this->belongsTo(PhilippineProvince::class, 'province_code', 'province_code');
    }

    public function cityJoin()
    {
        return $this->belongsTo(PhilippineCity::class, 'city_municipality_code', 'city_municipality_code');
    }

    public function barangayJoin()
    {
        return $this->belongsTo(PhilippineBarangay::class, 'barangay_code', 'barangay_code');
    }

    public function getFullAddressAttribute()
    {
        return "{$this->street}, {$this->barangayJoin->barangay_description}, {$this->cityJoin->city_municipality_description}, {$this->provinceJoin->province_description}";
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('street', 'like', "%{$value}%")
            ->orWhereHas('provinceJoin', function ($query) use ($value) {
                $query->where('province_description', 'like', "%{$value}%");
            })
            ->orWhereHas('cityJoin', function ($query) use ($value) {
                $query->where('city_municipality_description', 'like', "%{$value}%");
            })
            ->orWhereHas('barangayJoin', function ($query) use ($value) {
                $query->where('barangay_description', 'like', "%{$value}%");
            });
    }
}
