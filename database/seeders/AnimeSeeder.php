<?php

namespace Database\Seeders;

use App\Models\Anime;
use App\Models\Genre;
use App\Models\Studio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnimeSeeder extends Seeder
{
    public function run(): void
    {
        $studio = Studio::first();
        if (!$studio) return;

        $animes = [
            [
                'title' => 'Jujutsu Kaisen',
                'synopsis' => 'A boy swallows a cursed talisman - the finger of a demon - and becomes cursed himself. He enters a shaman\'s school to be able to locate the demon\'s other body parts and thus exorcise himself.',
                'poster_image' => 'https://m.media-amazon.com/images/M/MV5BNGY4MTg3NzgtMmFkZi00NTg5LWExMmEtMWI3YzI1ODdmMWQ1XkEyXkFqcGdeQXVyMjQwMDg0Ng@@._V1_.jpg',
                'banner_image' => 'https://images7.alphacoders.com/133/1330661.png',
                'type' => 'TV',
                'status' => 'Ongoing',
                'aired_at' => '2020-10-03',
                'is_premium' => false,
            ],
            [
                'title' => 'Kimetsu no Yaiba',
                'synopsis' => 'A family is attacked by demons and only two members survive - Tanjiro and his sister Nezuko, who is turning into a demon slowly. Tanjiro sets out to become a demon slayer to avenge his family and cure his sister.',
                'poster_image' => 'https://m.media-amazon.com/images/M/MV5BZjZjNzI5MDctY2YyZC00NmM0LThlZWItMDhmYmQyYTgzOTQ2XkEyXkFqcGdeQXVyNjU1OTg0OTM@._V1_FMjpg_UX1000_.jpg',
                'banner_image' => 'https://images.alphacoders.com/100/1006900.png',
                'type' => 'TV',
                'status' => 'Completed',
                'aired_at' => '2019-04-06',
                'is_premium' => true,
            ],
            [
                'title' => 'Sousou no Frieren',
                'synopsis' => 'The Demon King has been defeated, and the victorious hero party returns home before disbanding. The four—mage Frieren, hero Himmel, priest Heiter, and warrior Eisen—reminisce about their decade-long journey as the moment to bid each other farewell arrives.',
                'poster_image' => 'https://m.media-amazon.com/images/M/MV5BMjY5YjYyMDItNDQ1My00NjUyLTg0OTctYTkzM2I0YWE1ZTI2XkEyXkFqcGdeQXVyMjgxODQ5NDk@._V1_FMjpg_UX1000_.jpg',
                'banner_image' => 'https://images7.alphacoders.com/133/1337452.jpg',
                'type' => 'TV',
                'status' => 'Ongoing',
                'aired_at' => '2023-09-29',
                'is_premium' => true,
            ],
            [
                'title' => 'Oshi no Ko',
                'synopsis' => 'Gorou Amemiya, a countryside gynecologist and otaku, is killed by an obsessive fan of his favorite idol, Ai Hoshino, only to be reincarnated as her twin child, Aquamarine Hoshino.',
                'poster_image' => 'https://m.media-amazon.com/images/M/MV5BZjQ5ZDRkNzAtODViOC00NDZjLTlhZTEtMzYyMTg0YjI5NzRmXkEyXkFqcGdeQXVyMTU2NTcwMzQ0._V1_.jpg',
                'banner_image' => 'https://images8.alphacoders.com/131/1313794.jpeg',
                'type' => 'TV',
                'status' => 'Ongoing',
                'aired_at' => '2023-04-12',
                'is_premium' => false,
            ],
            [
                'title' => 'Chainsaw Man',
                'synopsis' => 'Following a betrayal, a young man left for the dead is reborn as a powerful devil-human hybrid after merging with his pet devil and is soon enlisted into an organization dedicated to hunting devils.',
                'poster_image' => 'https://m.media-amazon.com/images/M/MV5BZjY5MjBkMzAtYzQxMC00Y2NhLWJjZjgtMGU4ZmZhODgyNDVkXkEyXkFqcGdeQXVyNDgyODgxNjE@._V1_.jpg',
                'banner_image' => 'https://images3.alphacoders.com/129/1296716.jpg',
                'type' => 'TV',
                'status' => 'Completed',
                'aired_at' => '2022-10-12',
                'is_premium' => true,
            ],
            [
                'title' => 'One Piece',
                'synopsis' => 'Gol D. Roger was known as the Pirate King, the strongest and most infamous being to have sailed the Grand Line. Monkey D. Luffy, a 17-year-old boy who defies your standard definition of a pirate, follows in his footsteps.',
                'poster_image' => 'https://m.media-amazon.com/images/M/MV5BMTNjNGU4NTMtMTdjMy00MDA2LWI3NzEtZTE4NjY2YWNlZjEwXkEyXkFqcGdeQXVyMTE1MTYxNDAw._V1_.jpg',
                'banner_image' => 'https://images7.alphacoders.com/134/1341857.jpeg',
                'type' => 'TV',
                'status' => 'Ongoing',
                'aired_at' => '1999-10-20',
                'is_premium' => false,
            ],
            [
                'title' => 'Attack on Titan',
                'synopsis' => 'After his hometown is destroyed and his mother is killed, young Eren Jaeger vows to cleanse the earth of the giant humanoid Titans that have brought humanity to the brink of extinction.',
                'poster_image' => 'https://m.media-amazon.com/images/M/MV5BNDFjYTIxMjctYTQ2ZC00NjQwLTliMjMtYWMxOTQyOWU1MWU4XkEyXkFqcGdeQXVyNzEyMTAwNzA@._V1_.jpg',
                'banner_image' => 'https://images.alphacoders.com/112/1128229.png',
                'type' => 'TV',
                'status' => 'Completed',
                'aired_at' => '2013-04-07',
                'is_premium' => true,
            ],
            [
                'title' => 'Bleach: Thousand-Year Blood War',
                'synopsis' => 'The peace is suddenly broken when warning sirens blare through the Soul Society. Residents are disappearing without a trace and nobody knows who\'s behind it.',
                'poster_image' => 'https://m.media-amazon.com/images/M/MV5BODdhZGM3YjgtNDAxOC00ZDFiLWEwZDYtZTIyNmJmZDIxY2E4XkEyXkFqcGdeQXVyMjgxODQ5NDk@._V1_.jpg',
                'banner_image' => 'https://images5.alphacoders.com/127/1272714.png',
                'type' => 'TV',
                'status' => 'Ongoing',
                'aired_at' => '2022-10-11',
                'is_premium' => true,
            ],
            [
                'title' => 'Solo Leveling',
                'synopsis' => 'In a world where hunters, humans who possess magical abilities, must battle deadly monsters to protect the human race from certain annihilation, a notoriously weak hunter named Sung Jinwoo finds himself in a seemingly endless struggle for survival.',
                'poster_image' => 'https://m.media-amazon.com/images/M/MV5BODViZWRhYjktY2I0ZC00MWZlLWI0N2UtYjA5YzkwNzM2YDEwXkEyXkFqcGdeQXVyMTUzOTcyODA5._V1_.jpg',
                'banner_image' => 'https://images7.alphacoders.com/134/1345914.png',
                'type' => 'TV',
                'status' => 'Ongoing',
                'aired_at' => '2024-01-07',
                'is_premium' => true,
            ],
            [
                'title' => 'Naruto Shippuden',
                'synopsis' => 'It has been two and a half years since Naruto Uzumaki left Konohagakure, the Hidden Leaf Village, for intense training following events which fueled his desire to be stronger.',
                'poster_image' => 'https://m.media-amazon.com/images/M/MV5BZGExYjI5NWYtZTEyMi00NzZmLWI2MDctYmY1YTA1MGUyY2M0XkEyXkFqcGdeQXVyMTA3MTA4Mzgw._V1_.jpg',
                'banner_image' => 'https://images5.alphacoders.com/132/1327178.png',
                'type' => 'TV',
                'status' => 'Completed',
                'aired_at' => '2007-02-15',
                'is_premium' => false,
            ],
        ];

        foreach ($animes as $data) {
            $anime = Anime::updateOrCreate(
                ['title' => $data['title']], 
                array_merge($data, [
                    'slug' => Str::slug($data['title']),
                    'studio_id' => Studio::inRandomOrder()->first()?->id ?? null
                ])
            );
            
            // Attach random genres
            $anime->genres()->sync(Genre::inRandomOrder()->take(rand(2, 4))->pluck('id'));
        }
    }
}
