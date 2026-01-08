<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$episodes = \App\Models\Episode::all();
foreach ($episodes as $ep) {
    echo $ep->video_url . "\n";
}
