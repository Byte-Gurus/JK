<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
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
            'firstname' => fake()->lastName(),
            'middlename' => fake()->lastName(),
            'lastname' => fake()->lastName(),
            'birthdate' => $this->faker->dateTimeBetween('-60 years', '-18 years')->format('d-m-Y'),
            'contact_number' => fake()->unique()->numerify('###########'),
            'customer_type' => fake()->randomElement(['Walk in', 'PWD', 'Senior Citizen', 'Credit']),
            'customer_discount_no' => Str::random(10),
            'id_picture' => $this->faker->imageUrl(),
            'address_id' => $address->id,
        ];
    }
}
