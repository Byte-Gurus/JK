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

    public function scopeSearch($query, $value)
    {

        return $query->where('firstname', 'like', "%{$value}%")
                     ->orWhere('middlename', 'like', "%{$value}%")
                     ->orWhere('lastname', 'like', "%{$value}%")
                     ->orWhere('customer_discount_no', 'like', "%{$value}%")
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
