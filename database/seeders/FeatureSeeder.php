<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Suki ni Ancog', 'Budget Meal', 'Halal', 'Open 24 Hours', 'Aircon', 'Unli Rice'] as $name) {
            Feature::create(['name' => $name]);
        }
    }
}
