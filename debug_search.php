<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$query = "solo leveling";
$results = [];

$res = Http::withoutVerifying()->get("https://www.sankavollerei.com/anime/search/" . urlencode($query));
if ($res->successful()) $results['otakudesu'] = $res->json();

$res2 = Http::withoutVerifying()->get("https://www.sankavollerei.com/anime/samehadaku/search", ['q' => $query]);
if ($res2->successful()) $results['samehadaku'] = $res2->json();

file_put_contents('search_debug.json', json_encode($results, JSON_PRETTY_PRINT));
echo "Saved to search_debug.json\n";
