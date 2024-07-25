<?php

namespace Database\Factories;

use App\Models\PhilippineBarangay;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

       // Randomly pick a province
       $province = PhilippineProvince::inRandomOrder()->first();

       // If a province is found, get a city or municipality from that province
       if ($province) {
           $city = PhilippineCity::where('province_code', $province->province_code)->inRandomOrder()->first();

           // If a city or municipality is found, get a barangay from that city
           if ($city) {
               $barangay = PhilippineBarangay::where('city_municipality_code', $city->city_municipality_code)->inRandomOrder()->first();
           } else {
               $barangay = null; // Handle case when no city is found
           }
       } else {
           $city = null; // Handle case when no province is found
           $barangay = null;
       }

       return [
           'province_code' => $province->province_code ?? null,
           'city_municipality_code' => $city->city_municipality_code ?? null,
           'barangay_code' => $barangay->barangay_code ?? null,
           'street' => $this->faker->streetName(),
       ];
    }
}
