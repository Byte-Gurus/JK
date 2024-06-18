<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\User;
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
        $this->call(UserSeeder::class);
        User::factory(100)->create();

        $this->call(PhilippineRegionsTableSeeder::class);
        $this->call(PhilippineProvincesTableSeeder::class);
        $this->call(PhilippineCitiesTableSeeder::class);
        $this->call(PhilippineBarangaysTableSeeder::class);

        Supplier::factory(100)->create();
    }
}
