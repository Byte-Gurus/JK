<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrationOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate tables in order to prevent errors from foreign keys';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //* list all the mirgations in order here
        $migrations = [
            '2024_06_03_052410_user_role_table.php',
            '0001_01_01_000000_create_users_table.php'
        ];

        //* call them in loop, in order here
        foreach ($migrations as $migration) {
            $basePath = 'database/migrations/';
            $migrationName = trim($migration);
            $path = $basePath . $migrationName;
            $this->call('migrate', [
                '--path' => $path,
            ]);
        }
    }
}
