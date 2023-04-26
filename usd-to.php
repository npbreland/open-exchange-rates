<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!isset($_ENV['APP_ID'])) {
    echo "You must set the APP_ID environment variable" . PHP_EOL;
    exit;
}

if (!isset($argv[1])) {
    echo "You must specify a currency code" . PHP_EOL;
    exit;
}

define('APP_ID', $_ENV['APP_ID']);
define('URL', 'https://openexchangerates.org/api/latest.json?app_id='.APP_ID);

$code = $argv[1];

// Note: free plan allows up to 1000 requests per month.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

$data = json_decode($output, true);

if (!isset($data['rates'][$code])) {
    echo "Invalid currency code" . PHP_EOL;
    exit;
}

echo $data['rates'][$code];
