<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Supplier;
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

        $status = $this->faker->randomElement(['Expired', 'Available', 'Not available']);
        $quantity = ($status === 'Not available') ? 0 : $this->faker->numberBetween(1, 100);

        return [
            'sku_code' => 'SKU-' . $this->faker->unique()->numerify('######'),
            'cost' => $this->faker->randomFloat(2, 1, 100), // Random float between 1 and 100
            'mark_up_price' => $this->faker->randomFloat(2, 1, 100),
            'selling_price' => $this->faker->randomFloat(2, 1, 100),
            'current_stock_quantity' => $quantity,
            'expiration_date' => $this->faker->dateTime(),
            'stock_in_date' => $this->faker->dateTime(),
            'status' => $status,
            'item_id' => Item::all()->random()->id,
            'supplier_id' => Supplier::all()->random()->id,
        ];
    }
}
