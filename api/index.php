<?php

// 1. Matikan pengecekan storage permanen
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');

// 2. Buat folder view sementara agar Laravel tidak "panic"
@mkdir('/tmp/storage/framework/views', 0755, true);

require __DIR__ . '/../public/index.php';
