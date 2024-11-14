<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'contact_person',
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
    public function supplierItemsJoin()
    {
        return $this->hasMany(SupplierItems::class, 'supplier_id');
    }

    public function scopeSearch($query, $value)
    {
        $value = strtolower($value);
        $value = trim($value);

        return $query->whereRaw('LOWER(company_name) LIKE ?', ["%{$value}%"])
            ->orWhereRaw('LOWER(contact_number) LIKE ?', ["%{$value}%"])
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
