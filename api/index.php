<?php
// Membuat folder sementara untuk Laravel di server Vercel
@mkdir('/tmp/storage/framework/views', 0755, true);
@mkdir('/tmp/storage/framework/cache', 0755, true);
@mkdir('/tmp/storage/framework/sessions', 0755, true);

require __DIR__ . '/../public/index.php';
