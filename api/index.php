<?php
// Buat folder temporary untuk cache Laravel di Vercel
mkdir('/tmp/storage/framework/views', 0755, true);

require __DIR__ . '/../public/index.php';
