<?php

// Generate a random key with 32 bytes (256 bits)
$randomKey = bin2hex(random_bytes(32));

echo 'Generated Secret Key: ' . $randomKey . PHP_EOL;