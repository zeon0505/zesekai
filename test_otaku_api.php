<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$id = "1piece-sub-indo";
$res = Http::withoutVerifying()->get("https://www.sankavollerei.com/anime/anime/$id");
$data = $res->json();
$d = $data['data'] ?? $data;
echo "SYNOPSIS JSON:\n";
echo json_encode($d['synopsis'], JSON_PRETTY_PRINT);
