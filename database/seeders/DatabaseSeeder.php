<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'andrew', // Ensure it's lowercase
            'email' => 'andrewjuan@gmail.com',
            'password' => bcrypt('andrewjuan'), // Fix password hashing
        ]);

        $this->call([
            GenreSeeder::class, // Add GenreSeeder first
            FollowerSeeder::class,
            MediaSeeder::class, // MediaSeeder should come after GenreSeeder
        ]);
    }
}
