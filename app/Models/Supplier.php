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
        'status_id',
        'address_id',
    ];


    //? i join ang suppler sa ibang tables

    public function statusJoin()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function addressJoin()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function scopeSearch($query, $value)
    {

        return $query->where('company_name', 'like', "%{$value}%")
                     ->orWhere('contact_number', 'like', "%{$value}%")
                     ->orWhereHas('addressJoin', function ($query) use ($value) {
                         $query->where('street', 'like', "%{$value}%")
                               ->orWhereHas('provinceJoin', function ($query) use ($value) {
                                   $query->where('province_description', 'like', "%{$value}%");
                               })
                               ->orWhereHas('cityJoin', function ($query) use ($value) {
                                   $query->where('city_municipality_description', 'like', "%{$value}%");
                               })
                               ->orWhereHas('barangayJoin', function ($query) use ($value) {
                                   $query->where('barangay_description', 'like', "%{$value}%");
                               });
                     });
    }
}
