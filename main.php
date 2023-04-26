<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('APP_ID', $_ENV['APP_ID']);

// Write curl request to get data from Open Exchange Rate API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://openexchangerates.org/api/latest.json?app_id=".APP_ID);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

$data = json_decode($output, true);

echo $data['rates']['GBP'];
