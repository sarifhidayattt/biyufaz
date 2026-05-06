<?php

// Paksa Laravel menggunakan folder /tmp yang bisa ditulis di Vercel
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');

// Buat folder view sementara agar tidak error "Target class [view] does not exist"
@mkdir('/tmp/storage/framework/views', 0755, true);

require __DIR__ . '/../public/index.php';
