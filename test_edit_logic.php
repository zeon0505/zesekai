<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Livewire\Admin\Anime\Edit;

$edit = new Edit();
$query = "solo leveling";
echo "Searching for '$query' on otakudesu...\n";
$results = $edit->searchOnApiServer($query, 'otakudesu');
echo "Found " . count($results) . " results.\n";

if (!empty($results)) {
    $first = $results[0];
    echo "Importing: " . $first['judul'] . " ID: " . $first['url'] . "\n";
    $data = $edit->getAnimeInfoServer($first['url'], 'otakudesu');
    if ($data) {
        echo "SUCCESS! Title: " . $data['title'] . "\n";
        echo "Synopsis Preview: " . substr($data['synopsis'], 0, 100) . "...\n";
    } else {
        echo "FAILED: getAnimeInfoServer returned null\n";
    }
}
