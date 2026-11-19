<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id');
        $tita = User::where('email', 'tita.ancog@kaonta.test')->firstOrFail();
        $mine = Eatery::where('slug', 'carinderia-ni-ancog')->firstOrFail();

        // Carinderia ni Ancog: 3 reviews, including Tita's 5-star review.
        $othersIds = $userIds->reject(fn (int $id): bool => $id === $tita->id);

        Review::factory()->count(2)->for($mine)
            ->state(fn (): array => ['user_id' => $othersIds->random()])
            ->create();

        Review::factory()->for($mine)->for($tita)->create([
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Ancog.',
            'created_at' => now(),
        ]);

        // Open factory eateries: 0–6 reviews each by random users. Closed eateries get none.
        $openFactoryEateries = Eatery::where('is_open', true)->whereKeyNot($mine->id)->get();

        foreach ($openFactoryEateries as $eatery) {
            Review::factory()->count(random_int(0, 6))->for($eatery)
                ->state(fn (): array => ['user_id' => $userIds->random()])
                ->create();
        }
    }
}
