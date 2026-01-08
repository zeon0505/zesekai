<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$component = new \App\Livewire\Admin\Episode\Create();
$anime = \App\Models\Anime::first();
$component->mount($anime);

echo "Testing Samehadaku Search...\n";
$results = $component->searchOnApiServer('jujutsu', 'samehadaku');
echo "Found: " . count($results) . " results.\n";
if(!empty($results)) {
    echo "First Result: " . $results[0]['judul'] . " (" . $results[0]['url'] . ")\n";
    echo "Testing samehadaku Detail...\n";
    $details = $component->getApiDetailsServer($results[0]['url'], 'samehadaku');
    echo "Episodes Found: " . count($details) . "\n";
}

echo "\nTesting Kusonime Search...\n";
$resultsK = $component->searchOnApiServer('jujutsu', 'kusonime');
echo "Found: " . count($resultsK) . " results.\n";
if(!empty($resultsK)) {
    echo "First Result: " . $resultsK[0]['judul'] . " (" . $resultsK[0]['url'] . ")\n";
    echo "Testing Kusonime Detail...\n";
    $detailsK = $component->getApiDetailsServer($resultsK[0]['url'], 'kusonime');
    echo "Download Lots Found: " . count($detailsK) . "\n";
}
