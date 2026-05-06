<?php

// Mengabaikan peringatan jika folder sudah ada
@mkdir('/tmp/storage/framework/views', 0755, true);

require __DIR__ . '/../public/index.php';
