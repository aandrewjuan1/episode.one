<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Media;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();
        $media = Media::all();

        if ($users->isEmpty() || $media->isEmpty()) {
            $this->command->info('Skipping ReviewSeeder: No users or media found.');
            return;
        }

        foreach (range(1, 50) as $index) {
            Review::create([
                'user_id' => $users->random()->id,
                'media_id' => $media->random()->id,
                'rating' => $faker->numberBetween(1, 5),
                'comment' => $faker->sentence(),
            ]);
        }
    }
}
