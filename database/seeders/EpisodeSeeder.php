<?php

namespace Database\Seeders;

use App\Models\Anime;
use App\Models\Episode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class EpisodeSeeder extends Seeder
{
    public function run(): void
    {
        $animes = Anime::all();

        foreach ($animes as $anime) {
            // Kita tambahkan 2 episode contoh untuk setiap anime
            // Untuk demo, kita gunakan link Pixeldrain yang user pakai tadi atau link storage
            
            Episode::updateOrCreate(
                ['anime_id' => $anime->id, 'episode_number' => 1],
                [
                    'title' => 'Pertemuan Pertama',
                    'video_url' => 'https://pixeldrain.com/api/file/xmuc8d3R', // Link contoh dari chat user
                    'thumbnail_image' => $anime->poster_image,
                ]
            );

            Episode::updateOrCreate(
                ['anime_id' => $anime->id, 'episode_number' => 2],
                [
                    'title' => 'Kekuatan yang Tersembunyi',
                    'video_url' => 'https://pixeldrain.com/api/file/xmuc8d3R', // Gunakan link sama untuk demo
                    'thumbnail_image' => $anime->poster_image,
                ]
            );
        }
    }
}
