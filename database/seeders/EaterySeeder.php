<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    public function run(): void
    {
        $this->seedMyEatery();
        $this->seedFactoryEateries();
    }

    /** Carinderia ni Ancog, made by hand (not by the factory). */
    private function seedMyEatery(): void
    {
        $name = 'Carinderia ni Ancog';

        $eatery = District::where('name', 'Poblacion')->firstOrFail()->eateries()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        $eatery->features()->sync(
            Feature::whereIn('name', ['Suki ni Ancog', 'Budget Meal'])->pluck('id')
        );

        $eatery->permit()->create([
            'permit_no' => 'DVO-2026-0617',
            'expires_on' => '2027-06-17',
        ]);

        $eatery->dishes()->createMany([
            ['name' => 'Tinolang Manok', 'price' => 85.00, 'is_bestseller' => true],
            ['name' => 'Kinilaw na Tuna', 'price' => 120.00, 'is_bestseller' => false],
            ['name' => 'Durian Shake', 'price' => 75.00, 'is_bestseller' => false],
        ]);
    }

    /** 14 factory eateries in random districts: 11 open + 3 closed. */
    private function seedFactoryEateries(): void
    {
        $districtIds = District::pluck('id');
        $featureIds = Feature::pluck('id');
        $randomDistrict = fn (): array => ['district_id' => $districtIds->random()];

        $eateries = Eatery::factory()->count(11)->state($randomDistrict)->create()
            ->concat(Eatery::factory()->closed()->count(3)->state($randomDistrict)->create());

        foreach ($eateries as $eatery) {
            Permit::factory()->for($eatery)->create();
            // for() sets eatery_id, so the factory's default Eatery::factory() is not run.
            Dish::factory()->count(random_int(2, 5))->for($eatery)->create();
            $eatery->features()->attach($featureIds->random(random_int(1, 3)));
        }

        // Guarantee at least one expired permit.
        $eateries->first()->permit()->update(['expires_on' => now()->subMonths(2)->toDateString()]);
    }
}
