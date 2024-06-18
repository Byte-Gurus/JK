<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_roles')->insert([
            'role' => 'Admin',
        ]);
        DB::table('user_roles')->insert([
            'role' => 'Cashier',
        ]);
        DB::table('user_roles')->insert([
            'role' => 'Inventory Staff',
        ]);
    }
}
