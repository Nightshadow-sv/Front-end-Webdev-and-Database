<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder {
    public function run(): void {
        foreach (['Technology','Business','Politics','Science','Health','Sports'] as $name) {
            Genre::firstOrCreate(['name' => $name]);
        }
    }
}