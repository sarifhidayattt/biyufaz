<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$serverKey = $_ENV['MIDTRANS_SERVER_KEY'];
$isProduction = filter_var($_ENV['MIDTRANS_IS_PRODUCTION'], FILTER_VALIDATE_BOOLEAN);

echo "Checking Midtrans Connection...\n";
echo "Server Key: " . substr($serverKey, 0, 10) . "...\n";
echo "Mode: " . ($isProduction ? "Production" : "Sandbox") . "\n";

\Midtrans\Config::$serverKey = $serverKey;
\Midtrans\Config::$isProduction = $isProduction;

try {
    $params = [
        'transaction_details' => [
            'order_id' => 'TEST-' . time(),
            'gross_amount' => 10000,
        ],
    ];
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    echo "SUCCESS! Snap Token: " . $snapToken . "\n";
} catch (\Exception $e) {
    echo "FAILED! Error: " . $e->getMessage() . "\n";
}
