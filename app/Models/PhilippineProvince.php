<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhilippineProvince extends Model
{
    use HasFactory;

    protected $fillable = [
        'province_description',
    ];

    //? i join ang province sa ibang tables
    public function regionJoin()
    {
        return $this->belongsTo(PhilippineRegion::class, 'region_code', 'region_code');
    }

    public function citiesJoin()
    {
        return $this->hasMany(PhilippineCity::class, 'province_code', 'province_code');
    }

    public function barangaysJoin()
    {
        return $this->hasManyThrough(PhilippineBarangay::class, PhilippineCity::class, 'province_code', 'city_municipality_code', 'province_code', 'city_municipality_code');
    }
}
