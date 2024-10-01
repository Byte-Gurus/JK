<?php

use App\Models\Credit;
use App\Models\Inventory;
use App\Models\Notification;
use Carbon\Carbon;
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
        '2024_08_09_131524_create_purchases_table.php',
        '2024_08_09_142144_create_purchase_details_table.php',
        '2024_08_04_204401_create_deliveries_table.php',
        '2024_08_22_213514_create_back_orders_table.php',
        '2024_09_03_174035_create_discounts_table.php',
        '2024_09_02_212601_create_transactions_table.php',

        '2024_08_05_213148_create_inventories_table.php',
        '2024_08_16_234953_create_inventory_adjustments_table.php',


        '2024_09_03_101448_create_payments_table.php',
        '2024_09_02_213236_create_transaction_details_table.php',
        '2024_09_04_210427_create_credits_table.php',
        '2024_09_05_220930_create_credit_histories_table.php',

        '2024_08_26_221603_create_inventory_movements_table.php',
        '2024_09_07_233147_create_notifications_table.php',

        '2024_09_08_090928_create_returns_table.php',
        '2024_09_08_090030_create_return_details_table.php',

        '2024_09_27_123857_create_transaction_movements_table.php',

        '0001_01_01_000001_create_cache_table.php',
        '0001_01_01_000002_create_jobs_table.php',

    ];

    foreach ($migrations as $migration) {
        $basePath = 'database/migrations/';
        $migrationName = trim($migration);
        $path = $basePath . $migrationName;

        $this->call('migrate', [
            '--path' => $path,
        ]);

        $this->info("Migrated: {$migrationName}");
    }

    $this->comment('Migration completed!');
})->purpose('Migrate tables in order to prevent errors from foreign keys');


Artisan::command('inventory:check-expiration', function () {
    $this->comment('Checking for expired inventory items...');

    $today = Carbon::today();

    // Find expired items
    $expiredItems = Inventory::where('expiration_date', '<=', $today)
        ->where('status', 'Available')
        ->get();

    // Update status of expired items
    foreach ($expiredItems as $item) {
        $item->status = 'Expired';
        $item->save();
        $this->info("Updated status for item SKU: {$item->sku_code} to 'expired'");

        $notificationExists = Notification::where('description', "Item with SKU {$item->sku_code} has expired.")
            ->exists();

        if (!$notificationExists) {
            Notification::create([
                'description' => "Item with SKU {$item->sku_code} has expired.",
                'inventory_id' => $item->id,
            ]);
            $this->info("Added notification for item SKU: {$item->sku_code}");
        }

        $this->info("Updated status for item SKU: {$item->sku_code} to 'Expired' and added notification");
    }

    $this->comment('Expiration check completed!');
})->purpose('Check inventory items for expiration and update their status if expired')->daily();


Artisan::command('credit:check-overdue', function () {
    $this->comment('Checking for overdue creditor...');

    $today = Carbon::today();

    $overdueCreditor = Credit::where('due_date', '<=', $today)
        ->where('status', 'Pending')
        ->get();

    foreach ($overdueCreditor as $credit) {
        $credit->status = 'Overdue';
        $credit->save();
        $this->info("Updated status for credit number: {$credit->credit_number} to 'Overdue'");

        // Check if notification already exists
        $notificationExists = Notification::where('description', "Credit with number {$credit->credit_number} is overdue.")
            ->exists();

        if (!$notificationExists) {
            Notification::create([
                'description' => "Credit with number {$credit->credit_number} is overdue.",
                'credit_id' => $credit->id,
            ]);
            $this->info("Added notification for credit number: {$credit->credit_number}");
        }
    }
})->purpose('Check credit creditor and update status if overdue')->daily();
