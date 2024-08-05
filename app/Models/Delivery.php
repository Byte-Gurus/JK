<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
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
}
