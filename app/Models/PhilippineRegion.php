<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhilippineRegion extends Model
{
    use HasFactory;
    protected $fillable = [
        'region_description',
    ];

    public function provinces()
    {
        return $this->hasMany(PhilippineProvince::class, 'region_code', 'region_code');
    }

    public function cities()
    {
        return $this->hasManyThrough(PhilippineCity::class, PhilippineProvince::class, 'region_code', 'province_code', 'region_code', 'province_code');
    }

    public function barangays()
    {
        return $this->hasManyThrough(PhilippineBarangay::class, PhilippineCity::class, 'region_code', 'city_municipality_code', 'region_code', 'city_municipality_code');
    }
}
