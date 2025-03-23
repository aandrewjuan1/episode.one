<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            ['name' => 'Action'],
            ['name' => 'Comedy'],
            ['name' => 'Drama'],
            ['name' => 'Sci-Fi'],
            ['name' => 'Fantasy'],
            ['name' => 'Romance'],
            ['name' => 'Thriller'],
            ['name' => 'Horror'],
            ['name' => 'Mystery'],
            ['name' => 'Adventure'],
            ['name' => 'Slice of Life'],
            ['name' => 'Supernatural'],
            // Add more genres as needed
        ];

        DB::table('genres')->insert($genres);
    }
}
