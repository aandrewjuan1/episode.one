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
            'name' => 'andrew',
            'email' => 'andrewjuan@gmail.com',
            'password' => 'andrewjuan',
        ]);

        $this->call([
            GenreSeeder::class, // Add GenreSeeder first
            FollowerSeeder::class,
            MediaSeeder::class, // MediaSeeder should come after GenreSeeder
        ]);
    }
}
