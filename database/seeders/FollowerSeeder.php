<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\FollowerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all user IDs
        $userIds = User::all()->pluck('id')->toArray();

        if (count($userIds) < 2) {
            $this->command->warn("Need at least 2 users to create follower relationships.");
            return;
        }

        // Generate a random number of follower relationships
        $numberOfFollowers = rand(10, 50);

        // Generate and insert the data, making sure to avoid unique constraint errors.
        for ($i = 0; $i < $numberOfFollowers; $i++) {
            try {
                (new FollowerFactory())->create();
            } catch (\Illuminate\Database\QueryException $e) {
                // Ignore unique constraint errors (duplicate follower relationships)
            }
        }
    }
}
