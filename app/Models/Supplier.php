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
    public function province()
    {
        return $this->belongsTo(PhilippineProvince::class, 'province_code', 'province_code');
    }

    public function city()
    {
        return $this->belongsTo(PhilippineCity::class, 'city_municipality_code', 'city_municipality_code');
    }

    public function barangay()
    {
        return $this->belongsTo(PhilippineBarangay::class, 'barangay_code', 'barangay_code');
    }

    public function getFullAddressAttribute()
    {
        return "{$this->street}, {$this->barangay->barangay_description}, {$this->city->city_municipality_description}, {$this->province->province_description}, {$this->region->region_description}";
    }
}
