<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$episodes = \App\Models\Episode::latest()->take(5)->get();
foreach ($episodes as $ep) {
    echo "ID: " . $ep->id . "\n";
    echo "Title: " . $ep->title . "\n";
    echo "URL: " . $ep->video_url . "\n";
    echo "--------------------------\n";
}
