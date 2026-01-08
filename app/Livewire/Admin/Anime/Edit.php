<?php

namespace App\Livewire\Admin\Anime;

use App\Models\Anime;
use App\Models\Genre;
use App\Models\Studio;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

#[Layout('layouts.admin')]
class Edit extends Component
{
    public Anime $anime;
    
    public $title;
    public $synopsis;
    public $poster_image;
    public $banner_image;
    public $type;
    public $status;
    public $aired_at;
    public $is_premium;
    public $selectedGenres = [];
    
    // API Helper Properties
    public $selectedApiSource = 'sansekai';
    public $searchQuery = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'synopsis' => 'required|string',
        'poster_image' => 'required|url',
        'banner_image' => 'nullable|url',
        'type' => 'required|string',
        'status' => 'required|string',
        'aired_at' => 'required|date',
        'is_premium' => 'boolean',
        'selectedGenres' => 'array',
    ];

    public function mount(Anime $anime)
    {
        $this->anime = $anime;
        $this->title = $anime->title;
        $this->synopsis = $anime->synopsis;
        $this->poster_image = $anime->poster_image;
        $this->banner_image = $anime->banner_image;
        $this->type = $anime->type;
        $this->status = $anime->status;
        $this->aired_at = $anime->aired_at ? $anime->aired_at->format('Y-m-d') : null;
        // Studio removed
        $this->is_premium = (bool) $anime->is_premium;
        $this->selectedGenres = $anime->genres->pluck('id')->toArray();
    }

    public function update()
    {
        $validated = $this->validate();
        
        // Update slug only if title changes
        if ($this->title !== $this->anime->title) {
            $validated['slug'] = Str::slug($this->title);
        }

        $this->anime->update([
            'title' => $this->title,
            'slug' => $validated['slug'] ?? $this->anime->slug,
            'synopsis' => $this->synopsis,
            'poster_image' => $this->poster_image,
            'banner_image' => $this->banner_image,
            'type' => $this->type,
            'status' => $this->status,
            'aired_at' => $this->aired_at,
            'studio_id' => null,
            'is_premium' => $this->is_premium,
        ]);

        $this->anime->genres()->sync($this->selectedGenres);

        return redirect()->route('admin.anime.index')->with('message', 'Anime updated successfully.');
    }

    // --- MULTI-SOURCE API METHODS (SERVER-SIDE PROXY) ---

    private function apiRequest($url, $params = [])
    {
        try {
            return Http::withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'application/json',
                ])
                ->timeout(10)
                ->get($url, $params);
        } catch (\Exception $e) {
            \Log::error("Anime API Request Failed: " . $e->getMessage());
            return null;
        }
    }

    public function searchOnApiServer($query, $source = 'sansekai')
    {
        $cacheKey = "api_search_{$source}_" . md5($query);
        
        return \Cache::remember($cacheKey, 3600, function() use ($query, $source) {
            try {
                switch ($source) {
                    case 'sansekai':
                        $response = $this->apiRequest("https://api.sansekai.my.id/api/anime/search", ['query' => $query]);
                        if (!$response) return [];
                        $data = $response->json();
                        return $data['data'][0]['result'] ?? [];

                    case 'otakudesu':
                        $response = $this->apiRequest("https://www.sankavollerei.com/anime/search/" . urlencode($query));
                        if ($response && $response->successful()) {
                            $results = $response->json()['data']['animeList'] ?? [];
                            return array_map(fn($item) => [
                                'judul' => $item['title'] ?? '',
                                'url' => $item['animeId'] ?? '',
                                'cover' => $item['poster'] ?? '',
                                'type' => 'Anime',
                                'status' => $item['status'] ?? 'Unknown'
                            ], $results);
                        }
                        break;

                    case 'samehadaku':
                        $response = $this->apiRequest("https://www.sankavollerei.com/anime/samehadaku/search", ['q' => $query]);
                        if ($response && $response->successful()) {
                            $results = $response->json()['data']['animeList'] ?? [];
                            return array_map(fn($item) => [
                                'judul' => $item['title'] ?? '',
                                'url' => $item['animeId'] ?? '',
                                'cover' => $item['poster'] ?? '',
                                'type' => 'Anime',
                                'status' => $item['status'] ?? 'Unknown'
                            ], $results);
                        }
                        break;

                    case 'kusonime':
                        $response = $this->apiRequest("https://www.sankavollerei.com/anime/kusonime/search/" . urlencode($query));
                        if ($response && $response->successful()) {
                            $results = $response->json()['anime_list'] ?? [];
                            return array_map(fn($item) => [
                                'judul' => $item['title'] ?? '',
                                'url' => $item['slug'] ?? '',
                                'cover' => $item['poster'] ?? '',
                                'type' => 'Batch',
                                'status' => 'Completed'
                            ], $results);
                        }
                        break;
                }
            } catch (\Exception $e) {
                \Log::error("Anime Search Cache Error: " . $e->getMessage());
            }
            return [];
        });
    }

    public function getAnimeInfoServer($urlId, $source = 'sansekai')
    {
        \Log::info("Anime Helper: Fetching info for ID {$urlId} from {$source}");
        $cacheKey = "api_anime_info_{$source}_{$urlId}_v2"; // cache busting v2

        return \Cache::remember($cacheKey, 3600, function() use ($urlId, $source) {
            try {
                switch ($source) {
                    case 'sansekai':
                        $res = $this->apiRequest("https://api.sansekai.my.id/api/anime/detail", ['urlId' => $urlId]);
                        if ($res && $res->successful()) {
                            $d = $res->json()['data'][0] ?? null;
                            if (!$d) return null;
                            return [
                                'title' => $d['judul'] ?? '',
                                'synopsis' => $d['deskripsi'] ?? '',
                                'poster' => $d['cover'] ?? '',
                                'type' => $d['tipe'] ?? 'TV',
                                'status' => $d['status'] ?? 'Ongoing',
                                'aired' => $d['rilis'] ?? null,
                            ];
                        }
                        break;


                    case 'otakudesu':
                        \Log::info("GetAnimeInfoServer (Edit): Otakudesu - urlId={$urlId}");
                        
                        // Try standard endpoint
                        $url1 = "https://www.sankavollerei.com/anime/anime/" . $urlId;
                        \Log::info("Trying URL: {$url1}");
                        $res = $this->apiRequest($url1);
                        
                        // If not successful or API says not OK or no data
                        if (!$res || !$res->successful() || ($res->json()['ok'] ?? true) === false || empty($res->json()['data'])) {
                            $url2 = "https://www.sankavollerei.com/anime/detail/" . $urlId;
                            \Log::info("First attempt failed, trying fallback URL: {$url2}");
                            $res = $this->apiRequest($url2);
                        }

                        if ($res && $res->successful()) {
                            $json = $res->json();
                            \Log::info("Otakudesu API Success (Edit) - Response keys: " . json_encode(array_keys($json)));
                            
                            $d = $json['data'] ?? $json; // try 'data' key first, then root
                            \Log::info("Data keys: " . json_encode(array_keys($d ?? [])));
                            
                            if (!$d || (isset($d['title']) && empty($d['title']))) {
                                \Log::error("Otakudesu (Edit): Empty data or no title");
                                return null;
                            }

                            // Handle various synopsis structures
                            $syn = '';
                            if (isset($d['synopsis'])) {
                                if (is_array($d['synopsis'])) {
                                    if (isset($d['synopsis']['paragraphs'])) {
                                        $syn = implode("\n\n", $d['synopsis']['paragraphs']);
                                    } else {
                                        // Flatten nested arrays if any
                                        $flat = [];
                                        array_walk_recursive($d['synopsis'], function($a) use (&$flat) { $flat[] = $a; });
                                        $syn = implode("\n\n", $flat);
                                    }
                                } else {
                                    $syn = $d['synopsis'];
                                }
                            }

                            $result = [
                                'title' => $d['title'] ?? ($d['judul'] ?? ''),
                                'synopsis' => $syn ?: ($d['deskripsi'] ?? ''),
                                'poster' => $d['poster'] ?? ($d['cover'] ?? ''),
                                'type' => $d['type'] ?? ($d['tipe'] ?? 'TV'),
                                'status' => $d['status'] ?? 'Ongoing',
                                'aired' => $d['aired'] ?? ($d['rilis'] ?? null),
                            ];
                            
                            \Log::info("Otakudesu (Edit): Returning data - " . json_encode($result));
                            return $result;
                        } else {
                            $status = $res ? $res->status() : 'NO_RESPONSE';
                            \Log::error("Otakudesu API (Edit) Failed: HTTP {$status}");
                        }
                        break;


                    case 'samehadaku':
                        $res = $this->apiRequest("https://www.sankavollerei.com/anime/samehadaku/anime/" . $urlId);
                        if ($res && $res->successful()) {
                            $json = $res->json();
                            $d = $json['data'] ?? $json;
                            
                            if (!$d || (isset($json['ok']) && $json['ok'] === false)) return null;

                            $syn = '';
                            if (isset($d['synopsis'])) {
                                if (is_array($d['synopsis'])) {
                                    if (isset($d['synopsis']['paragraphs'])) {
                                        $syn = implode("\n\n", $d['synopsis']['paragraphs']);
                                    } else {
                                        // Flatten nested arrays if any
                                        $flat = [];
                                        array_walk_recursive($d['synopsis'], function($a) use (&$flat) { $flat[] = $a; });
                                        $syn = implode("\n\n", $flat);
                                    }
                                } else {
                                    $syn = $d['synopsis'];
                                }
                            }

                            return [
                                'title' => $d['title'] ?? '',
                                'synopsis' => $syn,
                                'poster' => $d['poster'] ?? '',
                                'type' => $d['type'] ?? 'TV',
                                'status' => $d['status'] ?? 'Ongoing',
                                'aired' => $d['aired'] ?? null,
                            ];
                        }
                        break;

                    case 'kusonime':
                        $res = $this->apiRequest("https://www.sankavollerei.com/anime/kusonime/detail/" . $urlId);
                        if ($res && $res->successful()) {
                            $d = $res->json()['detail'] ?? null;
                            if (!$d) return null;
                            return [
                                'title' => $d['title'] ?? '',
                                'synopsis' => $d['synopsis'] ?? '',
                                'poster' => $d['poster'] ?? '',
                                'type' => $d['info']['type'] ?? 'TV',
                                'status' => $d['info']['status'] ?? 'Completed',
                                'aired' => $d['info']['released'] ?? null,
                            ];
                        }
                        break;
                }
            } catch (\Exception $e) {
                \Log::error("Anime Info Error: " . $e->getMessage());
            }
            return null;
        });
    }

    public function setApiData($data)
    {
        if (!$data) return;

        $this->title = $data['title'] ?? $this->title;
        $this->synopsis = $data['synopsis'] ?? $this->synopsis;
        $this->poster_image = $data['poster'] ?? $this->poster_image;
        
        // Map Type
        $typeMap = ['TV' => 'TV', 'Movie' => 'Movie', 'OVA' => 'OVA', 'Special' => 'Special', 'TV Series' => 'TV'];
        $this->type = $typeMap[$data['type']] ?? $this->type;

        // Map Status
        $statusMap = ['Completed' => 'Completed', 'Ongoing' => 'Ongoing', 'Upcoming' => 'Upcoming', 'Airing' => 'Ongoing'];
        $this->status = $statusMap[$data['status']] ?? $this->status;
        
        if (!empty($data['aired'])) {
            try {
                // Try to parse various date formats
                $dateStr = str_replace(['Aired: ', 'Released: '], '', $data['aired']);
                // Handle "Jul 6, 2023 to Dec 28, 2023"
                if (str_contains($dateStr, ' to ')) {
                    $dateStr = explode(' to ', $dateStr)[0];
                }
                $this->aired_at = Carbon::parse($dateStr)->format('Y-m-d');
            } catch (\Exception $e) {
                // fall through
            }
        }
        
        session()->flash('api_message', 'Data imported from API!');
    }

    public function render()
    {
        return view('livewire.admin.anime.edit', [
            'genres' => Genre::all(),
        ]);
    }
}
