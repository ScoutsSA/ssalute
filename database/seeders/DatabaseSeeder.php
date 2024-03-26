<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(V3PermissionSeeder::class);

        if (config('features.local.seeders.enabled')) {
            $this->call(V3RegionSeeder::class);
            $this->call(V3DistrictSeeder::class);
            $this->call(V3GroupSeeder::class);
            $this->call(V3SectionSeeder::class);
            $this->call(V3SsaRoleSeeder::class);
        }
    }
}
