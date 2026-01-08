<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

$query = "naruto";
$url = "https://www.sankavollerei.com/anime/search/" . urlencode($query);

echo "Searching for $query via $url...\n";

$response = Http::withoutVerifying()->get($url);

if ($response->successful()) {
    $data = $response->json();
    echo "OK: " . ($data['ok'] ? 'Yes' : 'No') . "\n";
    $results = $data['data']['animeList'] ?? [];
    echo "Count: " . count($results) . "\n";
    
    if (!empty($results)) {
        $first = $results[0];
        echo "First Result Title: " . $first['title'] . "\n";
        echo "First Result ID: " . $first['animeId'] . "\n";
        
        $firstId = $first['animeId'];
        $detailUrl = "https://www.sankavollerei.com/anime/anime/" . $firstId;
        echo "\nFetching detail: $detailUrl\n";
        $res = Http::withoutVerifying()->get($detailUrl);
        if ($res->successful()) {
            $det = $res->json();
            echo "Detail OK: " . ($det['ok'] ? 'Yes' : 'No') . "\n";
            echo "Title: " . ($det['data']['title'] ?? 'N/A') . "\n";
            if (isset($det['data']['episodeList']) && count($det['data']['episodeList']) > 0) {
                $epId = $det['data']['episodeList'][0]['episodeId'];
                $epUrl = "https://www.sankavollerei.com/anime/episode/" . $epId;
                echo "\nFetching episode detail: $epUrl\n";
                $resEp = Http::withoutVerifying()->get($epUrl);
                if ($resEp->successful()) {
                    $epData = $resEp->json();
                    echo "Episode OK: " . ($epData['ok'] ? 'Yes' : 'No') . "\n";
                    $qualities = $epData['data']['server']['qualities'] ?? [];
                    if (!empty($qualities)) {
                        $firstQual = $qualities[0];
                        $serverList = $firstQual['serverList'] ?? [];
                        if (!empty($serverList)) {
                            $srv = $serverList[0];
                            $srvId = $srv['serverId'];
                            $srvUrl = "https://www.sankavollerei.com/anime/server/" . $srvId;
                            echo "Fetching Server Detail: $srvUrl\n";
                            $resSrv = Http::withoutVerifying()->get($srvUrl);
                            if ($resSrv->successful()) {
                                echo "Server OK: " . ($resSrv->json()['ok'] ? 'Yes' : 'No') . "\n";
                                echo "Final URL: " . ($resSrv->json()['data']['url'] ?? 'N/A') . "\n";
                            }
                        }
                    }
                } else {
                    echo "Episode Failed: " . $resEp->status() . "\n";
                }
            }
        } else {
            echo "Detail Failed: " . $res->status() . "\n";
        }
    }
} else {
    echo "Search Failed: " . $response->status() . "\n";
}
