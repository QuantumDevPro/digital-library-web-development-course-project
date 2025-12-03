<?php
// connection settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'digital_library_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Data Source Name (DSN)
define('DB_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4');

// PDO Options
$pdo_options = [
    // Throw exceptions on errors
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // Fetch associative arrays
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Use real prepared statements
    PDO::ATTR_EMULATE_PREPARES => false
];