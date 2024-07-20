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

        $province = PhilippineProvince::inRandomOrder()->first();

        $city = PhilippineCity::where('province_code', $province->province_code)->inRandomOrder()->first();

        $barangay = PhilippineBarangay::where('city_municipality_code', $city->city_municipality_code)->inRandomOrder()->first();

        return [
            
            'province_code' => $province->province_code,
            'city_municipality_code' => $city->city_municipality_code,
            'barangay_code' => $barangay->barangay_code,
            'street' => fake()->streetName(),
        ];
    }
}
