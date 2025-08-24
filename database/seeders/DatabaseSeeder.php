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
            AgencySeeder::class,
            AuditorSeeder::class,
            AuditAreaSeeder::class,
            AuditCriteriaSeeder::class,
            InternalControlSeeder::class,
            DocumentTypeSeeder::class,
            AuditTypeSeeder::class,
        ]);
    }
}
