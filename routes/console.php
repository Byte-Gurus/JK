<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('migration-order', function () {
    $this->comment('Starting migration in order...');

    $migrations = [
        '2024_07_26_214012_create_user_roles_table.php',
        '2024_06_16_160806_create_statuses_table.php',
        '0001_01_01_000000_create_users_table.php',
        '2024_07_26_214838_create_philippine_regions_table.php',
        '2024_07_26_214814_create_philippine_provinces_table.php',
        '2024_07_26_214728_create_philippine_cities_table.php',
        '2024_07_26_214701_create_philippine_barangays_table.php',
        '2024_07_20_201531_create_addresses_table.php',
        '2024_07_22_152908_create_customers_table.php',
        '2024_06_16_014707_create_suppliers_table.php',
        '2024_07_09_211729_create_items_table.php',
        '2024_08_05_213148_create_inventories_table.php',
        '2024_08_09_131524_create_purchases_table.php',
        '2024_08_09_142144_create_purchase_details_table.php',
        '2024_08_04_204401_create_deliveries_table.php',

        '0001_01_01_000001_create_cache_table.php',
        '0001_01_01_000002_create_jobs_table.php',

    ];

    foreach ($migrations as $migration) {
        $basePath = 'database/migrations/';
        $migrationName = trim($migration);
        $path = $basePath.$migrationName;

        $this->call('migrate', [
            '--path' => $path,
        ]);

        $this->info("Migrated: {$migrationName}");
    }

    $this->comment('Migration completed!');
})->purpose('Migrate tables in order to prevent errors from foreign keys');
