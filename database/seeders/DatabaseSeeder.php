<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Order matters: eateries need districts and features; reviews need eateries and users.
     */
    public function run(): void
    {
        $this->call([
            DistrictSeeder::class,
            FeatureSeeder::class,
            UserSeeder::class,
            EaterySeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
