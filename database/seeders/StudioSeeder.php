<?php

namespace Database\Seeders;

use App\Models\Studio;
use Illuminate\Database\Seeder;

class StudioSeeder extends Seeder
{
    public function run(): void
    {
        $studios = ['MAPPA', 'Ufotable', 'Kyoto Animation', 'Madhouse', 'Bones', 'Wit Studio', 'A-1 Pictures', 'Sunrise', 'Toei Animation', 'Studio Ghibli'];

        foreach ($studios as $studio) {
            Studio::firstOrCreate(['name' => $studio], ['slug' => \Illuminate\Support\Str::slug($studio)]);
        }
    }
}
