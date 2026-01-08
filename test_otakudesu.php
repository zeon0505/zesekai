<?php

function apiReq($url) {
    echo "\nRequesting: $url\n";
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0\r\nAccept: application/json\r\n"
        ],
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ]
    ];
    $context = stream_context_create($opts);
    $res = @file_get_contents($url, false, $context);
    if ($res === FALSE) {
        echo "Status: FAILED\n";
        return null;
    }
    echo "Status: OK\n";
    return json_decode($res, true);
}

echo "--- TESTING SAMEHADAKU VIDEO ---\n";

$searchS = apiReq("https://www.sankavollerei.com/anime/samehadaku/search?q=naruto");
if ($searchS && !empty($searchS['data']['animeList'])) {
    $animeId = $searchS['data']['animeList'][0]['animeId'];
    echo "Using Anime ID: $animeId\n";
    
    $detailS = apiReq("https://www.sankavollerei.com/anime/samehadaku/anime/$animeId");
    if($detailS && !empty($detailS['data']['episodeList'])) {
        $epId = $detailS['data']['episodeList'][0]['episodeId'];
        echo "Using Episode ID: $epId\n";
        
        $videoS = apiReq("https://www.sankavollerei.com/anime/samehadaku/episode/$epId");
        if($videoS) {
            echo "Default Stream: " . ($videoS['data']['defaultStreamingUrl'] ?? 'N/A') . "\n";
            if(isset($videoS['data']['server']['qualities'])) {
                 echo "Has Server Qualities: Yes\n";
                 $qual = $videoS['data']['server']['qualities'][0];
                 if(!empty($qual['serverList'])) {
                     $srvId = $qual['serverList'][0]['serverId'];
                     $finalS = apiReq("https://www.sankavollerei.com/anime/samehadaku/server/$srvId");
                     echo "Final URL: " . ($finalS['data']['url'] ?? 'N/A') . "\n";
                 }
            }
        }
    }
}
