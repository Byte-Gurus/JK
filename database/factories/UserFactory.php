<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    protected static ?string $password;
    /**
     *
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => fake()->lastName(),
            'middlename' => fake()->lastName(),
            'lastname' => fake()->lastName(),
            'contact_number' => fake()->unique()->numerify('###########'),
            'status_id' => fake()->randomElement([1, 2]),
            'user_role_id' => fake()->randomElement([1, 2, 3]),
            'username' => fake()->unique()->userName(),
            'password' => static::$password ??= Hash::make('password'),
            'user_image' => $this->faker->imageUrl(400, 400, 'people'),
            'remember_token' => Str::random(10),
        ];
    }
}
