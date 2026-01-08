<?php

use Illuminate\Support\Facades\Http;

function apiRequest($url) {
    try {
        return Http::withoutVerifying()
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'application/json',
            ])
            ->timeout(10)
            ->get($url);
    } catch (\Exception $e) {
        return null;
    }
}

function isValidVideoUrl($url) {
    if (!$url || !is_string($url)) return false;
    $blacklisted = ['wibuu.info', 'wibufile.com', 'zippyshare.com', 'racaty.net', 'gdriveplayer.us', 'gdriveplayer.me', 'No iframe found', '/server/', 'disini'];
    foreach($blacklisted as $b) {
        if(str_contains($url, $b)) return false;
    }
    return true;
}

$baseUrl = "https://www.sankavollerei.com/anime/samehadaku";
$chapterUrlId = "kimetsu-no-yaiba-mugen-ressha-hen-tv-series-episode-1";

echo "Testing Samehadaku EP Detail...\n";
$response = apiRequest($baseUrl . "/episode/" . $chapterUrlId);

if ($response && $response->successful()) {
    $data = $response->json();
    echo "Detail Fetch Success!\n";
    
    // Test Streaming Server
    if (isset($data['data']['server']['qualities'])) {
        foreach($data['data']['server']['qualities'] as $q) {
            foreach($q['serverList'] as $srv) {
                 echo "Checking Server: {$srv['title']} ({$srv['serverId']})...\n";
                 $resSrv = apiRequest($baseUrl . "/server/" . $srv['serverId']);
                 if($resSrv && $resSrv->successful()) {
                     $finalUrl = $resSrv->json()['data']['url'] ?? 'NONE';
                     echo "Result URL: {$finalUrl}\n";
                     if(isValidVideoUrl($finalUrl)) echo ">> VALID!\n"; else echo ">> BLACKLISTED\n";
                 } else {
                     echo ">> SERVER REQ FAILED\n";
                 }
            }
        }
    }

    // Default Url
    $def = $data['data']['defaultStreamingUrl'] ?? 'NONE';
    echo "Default Stream: {$def}\n";
    if(isValidVideoUrl($def)) echo ">> VALID!\n"; else echo ">> BLACKLISTED\n";
} else {
    echo "Detail Fetch Failed!\n";
}
