<?php

namespace Database\Factories;

use App\Models\Address;
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

        $address = Address::factory()->create();
        return [
            'company_name' => fake()->company(),
            'contact_number' => fake()->unique()->numerify('###########'),
            'status_id' => fake()->randomElement([1, 2]),
            'address_id' => $address->id,
            
        ];
    }
}
