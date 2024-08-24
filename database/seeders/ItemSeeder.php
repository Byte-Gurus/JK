<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Rice',
            'item_description' => 'Premium white rice',
            'maximum_stock_ratio' => 0.7,
            'reorder_percentage' => 0.5,
            'reorder_point' => 20,
            'vat_type' => 'Non vat',
            'vat_amount' => 0,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Cooking Oil',
            'item_description' => '1L Vegetable Oil',
            'maximum_stock_ratio' => 0.8,
            'reorder_percentage' => 0.6,
            'reorder_point' => 30,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Canned Sardines',
            'item_description' => '155g canned sardines in tomato sauce',
            'maximum_stock_ratio' => 0.9,
            'reorder_percentage' => 0.7,
            'reorder_point' => 50,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Instant Noodles',
            'item_description' => 'Beef flavor instant noodles',
            'maximum_stock_ratio' => 0.85,
            'reorder_percentage' => 0.65,
            'reorder_point' => 40,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Sugar',
            'item_description' => '1kg White sugar',
            'maximum_stock_ratio' => 0.75,
            'reorder_percentage' => 0.55,
            'reorder_point' => 25,
            'vat_type' => 'Non vat',
            'vat_amount' => 0,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Salt',
            'item_description' => '500g Iodized salt',
            'maximum_stock_ratio' => 0.8,
            'reorder_percentage' => 0.6,
            'reorder_point' => 30,
            'vat_type' => 'Non vat',
            'vat_amount' => 0,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Soy Sauce',
            'item_description' => '500ml Soy Sauce',
            'maximum_stock_ratio' => 0.75,
            'reorder_percentage' => 0.55,
            'reorder_point' => 35,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Vinegar',
            'item_description' => '500ml Vinegar',
            'maximum_stock_ratio' => 0.75,
            'reorder_percentage' => 0.55,
            'reorder_point' => 35,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Corned Beef',
            'item_description' => '300g can of corned beef',
            'maximum_stock_ratio' => 0.7,
            'reorder_percentage' => 0.5,
            'reorder_point' => 20,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Milk',
            'item_description' => '1L Full cream milk',
            'maximum_stock_ratio' => 0.85,
            'reorder_percentage' => 0.65,
            'reorder_point' => 25,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Tomato Sauce',
            'item_description' => '500ml Tomato Sauce',
            'maximum_stock_ratio' => 0.8,
            'reorder_percentage' => 0.6,
            'reorder_point' => 30,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Butter',
            'item_description' => '200g Butter',
            'maximum_stock_ratio' => 0.7,
            'reorder_percentage' => 0.5,
            'reorder_point' => 20,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Cheese',
            'item_description' => '250g Cheese',
            'maximum_stock_ratio' => 0.75,
            'reorder_percentage' => 0.55,
            'reorder_point' => 25,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Spaghetti',
            'item_description' => '500g Spaghetti noodles',
            'maximum_stock_ratio' => 0.8,
            'reorder_percentage' => 0.6,
            'reorder_point' => 30,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Ketchup',
            'item_description' => '500ml Ketchup',
            'maximum_stock_ratio' => 0.75,
            'reorder_percentage' => 0.55,
            'reorder_point' => 35,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Baking Powder',
            'item_description' => '200g Baking Powder',
            'maximum_stock_ratio' => 0.7,
            'reorder_percentage' => 0.5,
            'reorder_point' => 20,
            'vat_type' => 'Non vat',
            'vat_amount' => 0,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Tea',
            'item_description' => '100g Tea leaves',
            'maximum_stock_ratio' => 0.85,
            'reorder_percentage' => 0.65,
            'reorder_point' => 25,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Cereal',
            'item_description' => '500g Breakfast Cereal',
            'maximum_stock_ratio' => 0.8,
            'reorder_percentage' => 0.6,
            'reorder_point' => 30,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Mayonnaise',
            'item_description' => '500ml Mayonnaise',
            'maximum_stock_ratio' => 0.75,
            'reorder_percentage' => 0.55,
            'reorder_point' => 35,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Olive Oil',
            'item_description' => '500ml Olive Oil',
            'maximum_stock_ratio' => 0.7,
            'reorder_percentage' => 0.5,
            'reorder_point' => 20,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Chocolate',
            'item_description' => '100g Chocolate Bar',
            'maximum_stock_ratio' => 0.8,
            'reorder_percentage' => 0.6,
            'reorder_point' => 30,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Coffee',
            'item_description' => '250g Coffee Beans',
            'maximum_stock_ratio' => 0.75,
            'reorder_percentage' => 0.55,
            'reorder_point' => 25,
            'vat_type' => 'Vat',
            'vat_amount' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
