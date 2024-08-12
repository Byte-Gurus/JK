<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $inventory = Inventory::inRandomOrder()->first();


        $reorderPercentage = $this->faker->randomFloat(2, 1, 50);


        // $reorderPoint = $inventory ? $reorderPercentage * $inventory->quantity : 0;

        return [
            'barcode' => $this->faker->unique()->numerify('############'),
            'item_name' => $this->faker->word,
            'item_description' => $this->faker->sentence,
            'maximum_stock_ratio' => $this->faker->randomFloat(2, 1, 100),
            'reorder_percentage' => $reorderPercentage,
            // 'reorder_point' => $reorderPoint,
            'vat_type' => $this->faker->randomElement(['Vat', 'Non vat']),
            'vat_amount' => $this->faker->randomFloat(2, 0, 25),
            'status_id' => $this->faker->numberBetween(1, 2),
        ];
    }
}
