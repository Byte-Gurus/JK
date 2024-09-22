<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Vat;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //*call the other seeder class and seed them here
        $this->call(RoleSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DiscountSeeder::class);



        $this->call(PhilippineRegionsTableSeeder::class);
        $this->call(PhilippineProvincesTableSeeder::class);
        $this->call(PhilippineCitiesTableSeeder::class);
        $this->call(PhilippineBarangaysTableSeeder::class);

        // Supplier::factory(100)->create();
        // Customer::factory(100)->create();
        // $this->call(ItemSeeder::class);
        // Inventory::factory(100)->create();

    }
}
