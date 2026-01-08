<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Livewire\Admin\Anime\Edit;

$edit = new Edit();
$id = "solo-level-s2-sub-indo";
echo "Testing Otakudesu Import (ID: $id)...\n";

$data = $edit->getAnimeInfoServer($id, 'otakudesu');

if ($data) {
    echo "SUCCESS! Title: " . $data['title'] . "\n";
    echo "Synopsis Length: " . strlen($data['synopsis']) . "\n";
    echo "Synopsis Preview: " . substr($data['synopsis'], 0, 100) . "...\n";
} else {
    echo "FAILED: getAnimeInfoServer returned null\n";
}

$id2 = "1piece-sub-indo";
echo "\nTesting Otakudesu Import (ID: $id2)...\n";
$data2 = $edit->getAnimeInfoServer($id2, 'otakudesu');
if ($data2) {
    echo "SUCCESS! Title: " . $data2['title'] . "\n";
    echo "Synopsis Length: " . strlen($data2['synopsis']) . "\n";
    echo "Synopsis Preview: " . substr($data2['synopsis'], 0, 100) . "...\n";
} else {
    echo "FAILED: getAnimeInfoServer returned null\n";
}
