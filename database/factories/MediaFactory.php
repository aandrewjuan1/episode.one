<?php

namespace Database\Factories;

use App\Enums\MediaStatus;
use App\Enums\MediaType;
use App\Models\Media;
use App\Models\User;
use App\Models\Genre; // Import the Genre model
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Get an existing user ID, or create a new user if none exist.
        $userId = User::inRandomOrder()->first()->id ?? User::factory()->create()->id;

        return [
            'title' => implode(' ', $this->faker->words(rand(2, 3))), // FIXED
            'type' => $this->faker->randomElement(MediaType::cases())->value,
            'status' => $this->faker->randomElement(MediaStatus::cases())->value,
            'overview' => $this->faker->paragraph,
            'image_path' => 'https://picsum.photos/400/300?random=' . rand(1, 1000),
            'user_id' => $userId,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Media $media) {
            // Get a random number of genres (1 to 3)
            $genreIds = Genre::inRandomOrder()
                ->limit(rand(1, 3))
                ->pluck('id');

            // Attach the genres to the media
            $media->genres()->attach($genreIds);
        });
    }
}
