<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            // Seed agencies first
            AgencySeeder::class,
            AuditAreaSeeder::class,
            // Then seed auditors
            AuditorSeeder::class,
        ]);
    }
}
