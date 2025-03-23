<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class FollowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all()->pluck('id')->toArray();

        // Ensure follower_id and following_id are different
        $followerId = $this->faker->randomElement($users);
        $followingId = $this->faker->randomElement(array_diff($users, [$followerId]));

        return [
            'follower_id' => $followerId,
            'following_id' => $followingId,
        ];
    }

    public function create($attributes = [], $parent = null) // Added $parent = null
    {
        $data = array_merge($this->definition(), $attributes);

        DB::table('followers')->insert($data);

        return $data; // You can return the data if needed
    }
}
