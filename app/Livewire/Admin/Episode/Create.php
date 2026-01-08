<?php

namespace App\Livewire\Admin\Episode;

use App\Models\Anime;
use App\Models\Episode;
use Livewire\Attributes\Layout;
use Livewire\Component;

use Illuminate\Support\Facades\Http;

#[Layout('layouts.admin')]
class Create extends Component
{
    public Anime $anime;
    public $title;
    public $episode_number;
    public $video_url;
    public $thumbnail_image;

    // API Integration Properties
    public $apiSearch = '';
    public $apiResults = [];
    public $selectedApiAnime = null;
    public $apiEpisodes = [];
    public $showApiModal = false;
    public $selectedApiSource = 'sansekai';

    protected $rules = [
        'episode_number' => 'required|integer',
        'title' => 'nullable|string|max:255',
        'video_url' => 'required|url',
        'thumbnail_image' => 'nullable|url',
    ];

    public function mount(Anime $anime)
    {
        $this->anime = $anime;
        $lastEpisode = $anime->episodes()->orderBy('episode_number', 'desc')->first();
        $this->episode_number = $lastEpisode ? $lastEpisode->episode_number + 1 : 1;
    }

    public function save()
    {
        $this->validate();

        Episode::create([
            'anime_id' => $this->anime->id,
            'episode_number' => $this->episode_number,
            'title' => $this->title,
            'video_url' => $this->video_url,
            'thumbnail_image' => $this->thumbnail_image,
        ]);

        return redirect()->route('admin.anime.episodes.index', $this->anime->id)->with('message', 'Episode created successfully.');
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
            \Log::error("API Request Failed: " . $e->getMessage());
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
                \Log::error("Search Cache Error: " . $e->getMessage());
            }
            return [];
        });
    }

    public function getApiDetailsServer($urlId, $source = 'sansekai')
    {
        $cacheKey = "api_detail_{$source}_{$urlId}";

        return \Cache::remember($cacheKey, 3600, function() use ($urlId, $source) {
            try {
                switch ($source) {
                    case 'sansekai':
                        $response = $this->apiRequest("https://api.sansekai.my.id/api/anime/detail", ['urlId' => $urlId]);
                        if ($response && $response->successful()) {
                            return $response->json()['data'][0]['chapter'] ?? [];
                        }
                        break;

                    case 'otakudesu':
                        $response = $this->apiRequest("https://www.sankavollerei.com/anime/anime/" . $urlId);
                        if ($response && $response->successful()) {
                            $data = $response->json();
                            $episodes = $data['data']['episodeList'] ?? [];
                            return array_map(fn($ep) => [
                                'ch' => $ep['title'] ?? '',
                                'url' => $ep['episodeId'] ?? ''
                            ], $episodes);
                        }
                        break;

                    case 'samehadaku':
                        $response = $this->apiRequest("https://www.sankavollerei.com/anime/samehadaku/anime/" . $urlId);
                        if ($response && $response->successful()) {
                            $data = $response->json();
                            $episodes = $data['data']['episodeList'] ?? [];
                            return array_map(fn($ep) => [
                                'ch' => $ep['title'] ?? '',
                                'url' => $ep['episodeId'] ?? ''
                            ], $episodes);
                        }
                        break;

                case 'kusonime':
                    $response = $this->apiRequest("https://www.sankavollerei.com/anime/kusonime/detail/" . $urlId);
                    if ($response && $response->successful()) {
                        $data = $response->json();
                        $downloads = $data['detail']['download_links'] ?? [];
                        $mapped = [];
                        foreach($downloads as $dl) {
                            // Find a usable link (prefer Pixeldrain or Hexload for direct/fast access)
                            $targetLink = null;
                            foreach($dl['links'] as $link) {
                                if(in_array(strtolower($link['host']), ['pixeldrain', 'hexload', 'hxfile.co', 'zippyshare'])) {
                                    $targetLink = $link['url'];
                                    break;
                                }
                            }
                            if(!$targetLink && !empty($dl['links'])) $targetLink = $dl['links'][0]['url'];

                            $mapped[] = [
                                'ch' => $dl['resolution'] ?? 'Download',
                                'url' => $targetLink
                            ];
                        }
                        return $mapped;
                    }
                    break;
            }
        } catch (\Exception $e) {
            $this->dispatch('api-error', ['message' => "Gagal mengambil detail: " . $e->getMessage()]);
        }
        return [];
        });
    }

    public function getApiVideoServer($chapterUrlId, $source = 'sansekai')
    {
        try {
            if ($source === 'sansekai') {
                $response = $this->apiRequest("https://api.sansekai.my.id/api/anime/getvideo", [
                    'chapterUrlId' => $chapterUrlId,
                    'reso' => '720p'
                ]);
                if ($response && $response->successful()) {
                    $streams = $response->json()['data'][0]['stream'] ?? [];
                    return $streams[0]['link'] ?? null;
                }
                
                if ($response && $response->status() === 403) {
                    $msg = $response->json()['message'] ?? 'IP Anda terblokir oleh Sansekai.';
                    $this->dispatch('api-error', ['message' => $msg]);
                }
                
                return null;
            }

            if ($source === 'kusonime') {
                return $chapterUrlId;
            }

            // Samehadaku & Otakudesu
            $baseUrl = $source === 'otakudesu' 
                ? "https://www.sankavollerei.com/anime" 
                : "https://www.sankavollerei.com/anime/samehadaku";

            $response = $this->apiRequest($baseUrl . "/episode/" . $chapterUrlId);
            
            if ($response && $response->successful()) {
                $data = $response->json();
                \Log::info("Helper: Success fetch episode detail for {$chapterUrlId}");
                
                // --- 1. SANKA STREAMING SERVERS ---
                $serverList = [];
                if (isset($data['data']['server']['qualities'])) {
                    $qualities = $data['data']['server']['qualities'];
                    
                    $findQual = function($title) use ($qualities) {
                        foreach($qualities as $q) {
                            if(isset($q['title']) && str_contains(strtolower($q['title']), strtolower($title))) return $q['serverList'] ?? [];
                        }
                        return null;
                    };

                    $serverList = $findQual('720p') ?? $findQual('480p') ?? $findQual('360p') ?? $findQual('unknown');
                    
                    if(empty($serverList)) {
                        foreach($qualities as $q) {
                            if(!empty($q['serverList'])) {
                                $serverList = $q['serverList'];
                                break;
                            }
                        }
                    }
                }

                if(!empty($serverList)) {
                    \Log::info("Helper: Found " . count($serverList) . " servers for {$chapterUrlId}");
                    $bestServer = null;
                    foreach($serverList as $srv) {
                        if(in_array(strtolower($srv['title']), ['blogspot', 'blogger', 'mega', 'krakenfiles', 'yourupload'])) {
                            $bestServer = $srv;
                            break;
                        }
                    }
                    $selectedServer = $bestServer ?? $serverList[0];
                    \Log::info("Helper: Requesting serverId: " . ($selectedServer['serverId'] ?? 'N/A'));
                    $resServer = $this->apiRequest($baseUrl . "/server/" . ($selectedServer['serverId'] ?? ''));
                    
                    if($resServer && $resServer->successful()) {
                        $finalUrl = $this->unwrapUrl($resServer->json()['data']['url'] ?? null);
                        \Log::info("Helper: Got server URL: " . ($finalUrl ?: 'NULL'));
                        if ($finalUrl && $this->isValidVideoUrl($finalUrl)) return (string) $finalUrl;
                    } else {
                         \Log::warning("Helper: ServerId request failed or restricted for {$chapterUrlId}");
                    }
                } else {
                    \Log::info("Helper: No streaming servers found for {$chapterUrlId}");
                }

                // --- 2. DEFAULT STREAMING LINK ---
                $defaultUrl = $this->unwrapUrl($data['data']['defaultStreamingUrl'] ?? null);
                if ($defaultUrl && $this->isValidVideoUrl($defaultUrl)) {
                    \Log::info("Helper: Using defaultStreamingUrl: {$defaultUrl}");
                    return (string) $defaultUrl;
                }

                // --- 3. DOWNLOAD LINKS (FALLBACK) ---
                \Log::info("Helper: Entering download link fallback for {$chapterUrlId}");
                $allDlLinks = [];
                $dlData = $data['data']['downloadUrl'] ?? [];

                // Handle Samehadaku structure (formats -> qualities)
                if (isset($dlData['formats'])) {
                    foreach($dlData['formats'] as $fmt) {
                        foreach($fmt['qualities'] as $qual) {
                            foreach($qual['urls'] as $dl) {
                                $dl['url'] = $this->unwrapUrl($dl['url']);
                                $allDlLinks[] = $dl;
                            }
                        }
                    }
                } 
                // Handle Otakudesu structure (direct qualities)
                else if (isset($dlData['qualities'])) {
                    foreach($dlData['qualities'] as $qual) {
                        foreach($qual['urls'] as $dl) {
                            $dl['url'] = $this->unwrapUrl($dl['url']);
                            $allDlLinks[] = $dl;
                        }
                    }
                }

                if (!empty($allDlLinks)) {
                    \Log::info("Helper: Found " . count($allDlLinks) . " fallback download links");
                    $priorityHosts = ['gofile', 'krakenfiles', 'pixeldrain', 'mega', 'hexload', 'mediafire', 'acefile'];
                    foreach($priorityHosts as $host) {
                        foreach($allDlLinks as $dl) {
                            if(str_contains(strtolower($dl['title']), $host) || str_contains(strtolower($dl['url']), $host)) {
                                if($this->isValidVideoUrl($dl['url'])) {
                                    \Log::info("Helper: Fallback success with Host {$host}: {$dl['url']}");
                                    return (string) $dl['url'];
                                }
                            }
                        }
                    }
                    foreach($allDlLinks as $dl) {
                        if($this->isValidVideoUrl($dl['url'])) return (string) $dl['url'];
                    }
                }
            } else {
                $status = $response ? $response->status() : 'No Response';
                \Log::error("Helper: API Error {$status} for episode detail {$chapterUrlId}");
            }
        } catch (\Exception $e) {
             $this->dispatch('api-error', ['message' => "Gagal mengambil video: " . $e->getMessage()]);
        }
        return null;
    }

    private function unwrapUrl($url)
    {
        if (!$url) return null;

        // Unwrap wibuu.info / wibufile.com (usually blogger links)
        if (str_contains($url, 'wibuu.info') || str_contains($url, 'wibufile.com')) {
            $parsed = parse_url($url);
            if (isset($parsed['query'])) {
                parse_str($parsed['query'], $query);
                if (isset($query['url']) && !empty($query['url'])) {
                    \Log::info("Helper: Unwrapped URL from wrapper: " . $query['url']);
                    return $query['url'];
                }
            }
        }
        
        return $url;
    }

    private function isValidVideoUrl($url)
    {
        if (!$url || !is_string($url)) return false;
        
        // Block dead or problematic mirrors (that we can't unwrap)
        $blacklisted = [
            'zippyshare.com', 
            'racaty.net',
            'gdriveplayer.us',
            'gdriveplayer.me',
            'No iframe found', 
            '/server/', 
            'disini'
        ];

        // Special check for wrappers - if it's still wrapped and we reached here, it's bad
        if (str_contains($url, 'wibuu.info') || str_contains($url, 'wibufile.com')) {
             return false;
        }

        foreach($blacklisted as $b) {
            if(str_contains($url, $b)) return false;
        }
        
        return true;
    }

    public function setApiData($url, $number, $title = null)
    {
        $this->video_url = $url;
        $this->episode_number = $number;
        $this->title = $title;
        if(empty($this->thumbnail_image)) $this->thumbnail_image = $this->anime->poster_image;
        
        session()->flash('api_message', 'Data diimpor ke form! Klik Save untuk menyimpan.');
    }

    public function directSave($url, $number, $title)
    {
        Episode::updateOrCreate(
            [
                'anime_id' => $this->anime->id,
                'episode_number' => $number,
            ],
            [
                'title' => $title,
                'video_url' => $url,
                'thumbnail_image' => $this->anime->poster_image,
            ]
        );
    }

    public function render()
    {
        return view('livewire.admin.episode.create');
    }
}
