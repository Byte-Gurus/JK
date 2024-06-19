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

    //? i join ang region sa ibang tables
    public function provincesJoin()
    {
        return $this->hasMany(PhilippineProvince::class, 'region_code', 'region_code');
    }

    public function citiesJoin()
    {
        return $this->hasManyThrough(PhilippineCity::class, PhilippineProvince::class, 'region_code', 'province_code', 'region_code', 'province_code');
    }

    public function barangaysJoin()
    {
        return $this->hasManyThrough(PhilippineBarangay::class, PhilippineCity::class, 'region_code', 'city_municipality_code', 'region_code', 'city_municipality_code');
    }
}
