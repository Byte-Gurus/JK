<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vats')->insert([
            'vat_type' => 'Vat',
        ]);
        DB::table('vats')->insert([
            'vat_type' => 'Non Vat',
        ]);
    }
}
