<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\SsaRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);

        if (config('features.local.seeders.enabled')) {
            $this->call(RegionSeeder::class);
            $this->call(DistrictSeeder::class);
            $this->call(GroupSeeder::class);
            $this->call(SectionSeeder::class);
            $this->call(SsaRole::class);
        }
    }
}
