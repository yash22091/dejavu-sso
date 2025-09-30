<?php
// Simple .env loader for PHP
function load_env($path) {
    if (!file_exists($path)) return [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = array_map('trim', explode('=', $line, 2));
        $env[$key] = $value;
    }
    return $env;
}
?>
