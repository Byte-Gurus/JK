<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhilippineCity extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_municipality_description'
    ];

    public function provinceJoin()
    {
        return $this->belongsTo(PhilippineProvince::class, 'province_code', 'province_code');
    }

    public function barangaysJoin()
    {
        return $this->hasMany(PhilippineBarangay::class, 'city_municipality_code', 'city_municipality_code');
    }

    public function regionJoin()
    {
        return $this->belongsTo(PhilippineRegion::class, 'region_code', 'region_code');
    }
}
