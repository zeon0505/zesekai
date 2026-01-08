<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = ['Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Mecha', 'Mystery', 'Romance', 'Sci-Fi', 'Slice of Life', 'Sports', 'Supernatural'];

        foreach ($genres as $genre) {
            Genre::firstOrCreate(['name' => $genre], ['slug' => \Illuminate\Support\Str::slug($genre)]);
        }
    }
}
