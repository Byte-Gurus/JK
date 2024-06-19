<?php

namespace Database\Factories;

use App\Models\PhilippineProvince;
use App\Models\PhilippineCity;
use App\Models\PhilippineBarangay;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
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
            'company_name' => fake()->company(),
            'contact_number' => fake()->unique()->numerify('###########'),
            'status_id' => fake()->randomElement([1, 2]),
            'province_code' => $province->province_code,
            'city_municipality_code' => $city->city_municipality_code,
            'barangay_code' => $barangay->barangay_code,
            'street' => fake()->streetName(),
        ];
    }
}
