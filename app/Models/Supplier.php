<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'contact_number',
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
        return "{$this->street}, {$this->barangay->barangay_description}, {$this->city->city_municipality_description}, {$this->province->province_description}, {$this->region->region_description}";
    }

    public function scopeSearch($query, $value)
    {

        $query->where('company_name', 'like', "%{$value}%")
            ->orWhere('street', 'like', "%{$value}%")
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
