<?php
$ch = curl_init("https://api.sandbox.midtrans.com/v2/charge");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Uncomment if needed
$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "Connection Error: " . $error;
} else {
    echo "Connection Success: " . substr($response, 0, 100);
}
