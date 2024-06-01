<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'firstname' => 'Harth',
            'middlename' => 'Pama',
            'lastname' => 'Palaras',
            'contact_number' => '09185564553',
            'role' => 'Admin',
            'status' => 'Active',
            'username' => 'Aceboy76',
            'password' => Hash::make('200315feb'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Jade',
            'middlename' => 'Zoid',
            'lastname' => 'Agduma',
            'contact_number' => '09345678911',
            'role' => 'Admin',
            'status' => 'Active',
            'username' => 'Zoid',
            'password' => Hash::make('iloveaiah'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            
        ]);
    }
}
