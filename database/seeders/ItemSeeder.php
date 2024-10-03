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
            'maximum_stock_level' => 0,
            'bulk_quantity' => 10,
            'reorder_point' => 0,
            'shelf_life_type' => 'Perishable',
            'vat_type' => 'Vat',
            'vat_percent' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Cooking Oil',
            'item_description' => '1L Vegetable Oil',
            'maximum_stock_level' => 0,
            'bulk_quantity' => 10,
            'reorder_point' => 0,
            'shelf_life_type' => 'Non Perishable',
            'vat_type' => 'Non Vatable',
            'vat_percent' => 3,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Canned Sardines',
            'item_description' => '155g canned sardines in tomato sauce',
            'maximum_stock_level' => 0,
            'bulk_quantity' => 10,
            'reorder_point' => 0,
            'shelf_life_type' => 'Perishable',
            'vat_type' => 'Vat',
            'vat_percent' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Instant Noodles',
            'item_description' => 'Beef flavor instant noodles',
            'maximum_stock_level' => 0,
            'bulk_quantity' => 10,
            'reorder_point' => 0,
            'shelf_life_type' => 'Non Perishable',
            'vat_type' => 'Non Vatable',
            'vat_percent' => 3,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Sugar',
            'item_description' => '1kg White sugar',
            'maximum_stock_level' => 0,
            'bulk_quantity' => 10,
            'reorder_point' => 0,
            'shelf_life_type' => 'Perishable',
            'vat_type' => 'Vat',
            'vat_percent' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Salt',
            'item_description' => '500g Iodized salt',
            'maximum_stock_level' => 0,
            'bulk_quantity' => 10,
            'reorder_point' => 0,
            'shelf_life_type' => 'Non Perishable',
            'vat_type' => 'Non Vatable',
            'vat_percent' => 3,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Soy Sauce',
            'item_description' => '500ml Soy Sauce',
            'maximum_stock_level' => 0,
            'bulk_quantity' => 10,
            'reorder_point' => 0,
            'shelf_life_type' => 'Perishable',
            'vat_type' => 'Vat',
            'vat_percent' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Vinegar',
            'item_description' => '500ml Vinegar',
            'maximum_stock_level' => 0,
            'bulk_quantity' => 10,
            'reorder_point' => 0,
            'shelf_life_type' => 'Perishable',
            'vat_type' => 'Non Vatable',
            'vat_percent' => 3,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('items')->insert([
            'barcode' => Str::random(13),
            'item_name' => 'Corned Beef',
            'item_description' => '300g can of corned beef',
            'maximum_stock_level' => 0,
            'bulk_quantity' => 10,
            'reorder_point' => 0,
            'shelf_life_type' => 'Non Perishable',
            'vat_type' => 'Vat',
            'vat_percent' => 12,
            'status_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

}
