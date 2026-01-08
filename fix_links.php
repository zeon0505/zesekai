<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Episode;
use Illuminate\Support\Facades\Http;

$episodes = Episode::where('video_url', 'like', '%sankavollerei.com/anime/server/%')->get();
echo "Found " . $episodes->count() . " episodes with bad links.\n";

foreach ($episodes as $ep) {
    try {
        echo "Fixing Episode ID: " . $ep->id . " (" . $ep->title . ")...\n";
        $response = Http::withoutVerifying()->timeout(10)->get($ep->video_url);
        if ($response->successful()) {
            $data = $response->json();
            $newUrl = $data['data']['url'] ?? null;
            if ($newUrl && !str_contains($newUrl, '/anime/server/')) {
                $ep->video_url = $newUrl;
                $ep->save();
                echo "Success: " . $newUrl . "\n";
            } else {
                echo "Failed: No valid URL in JSON.\n";
            }
        } else {
            echo "Failed: API unreachable.\n";
        }
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
echo "Cleanup finished.\n";
