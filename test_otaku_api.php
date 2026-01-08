<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$query = "naruto";
echo "--- SEARCHING '$query' ---\n";
$res = Http::withoutVerifying()->get("https://www.sankavollerei.com/anime/search/" . urlencode($query));
if ($res->successful()) {
    $data = $res->json();
    echo "SEARCH RESULT COUNT: " . count($data['data']['animeList'] ?? []) . "\n";
    if (!empty($data['data']['animeList'])) {
        $first = $data['data']['animeList'][0];
        echo "FIRST RESULT KEYS: " . json_encode(array_keys($first)) . "\n";
        echo "FIRST RESULT DATA: " . json_encode($first) . "\n";
        
        $id = $first['id'] ?? $first['animeId'] ?? $first['slug'] ?? 'UNKNOWN';
        echo "\n--- FETCHING DETAIL FOR '$id' ---\n";
        $resDetail = Http::withoutVerifying()->get("https://www.sankavollerei.com/anime/anime/" . $id);
        if ($resDetail->successful()) {
            $dataDetail = $resDetail->json();
            echo "DETAIL RESULT:\n";
            // Print only structure keys
             print_r(array_keys($dataDetail['data'] ?? []));
             
             $eps = $dataDetail['data']['episodeList'] ?? [];
             echo "EPISODE COUNT: " . count($eps) . "\n";
             if(!empty($eps)) {
                 echo "FIRST EPISODE:\n";
                 print_r($eps[0]);
             }
        } else {
            echo "DETAIL FETCH FAILED: " . $resDetail->status() . "\n";
            echo $resDetail->body();
        }
    }
} else {
    echo "SEARCH FAILED: " . $res->status() . "\n";
    echo $res->body();
}
