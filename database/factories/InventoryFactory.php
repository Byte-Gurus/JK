<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // Randomly decide if the expiration date should be in the past or future
        $isExpired = $this->faker->boolean(30); // 30% chance of being expired
        $expirationDate = $isExpired
            ? Carbon::now()->subDays($this->faker->numberBetween(1, 365)) // Past date
            : Carbon::now()->addDays($this->faker->numberBetween(1, 365)); // Future date

        // Set the status based on the expiration date
        $status = $expirationDate < Carbon::now() ? 'Expired' : $this->faker->randomElement(['Available', 'Not available']);

        $quantity = ($status === 'Not available') ? 0 : $this->faker->numberBetween(1, 100);

        $activeItems = Item::where('status_id', 1)->get();

        return [
            'sku_code' => 'SKU-' . $this->faker->unique()->numerify('######'),
            'cost' => $this->faker->randomFloat(2, 1, 100), // Random float between 1 and 100
            'mark_up_price' => $this->faker->randomFloat(2, 1, 100),
            'selling_price' => $this->faker->randomFloat(2, 1, 100),
            'current_stock_quantity' => $quantity,
            'expiration_date' => $expirationDate,
            'stock_in_date' => $this->faker->dateTime(),
            'status' => $status,
            'item_id' => $activeItems->isNotEmpty() ? $activeItems->random()->id : null,
            'supplier_id' => Supplier::all()->random()->id,
        ];
    }
}
