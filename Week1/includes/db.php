<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'week1db');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('<div style="font-family:sans-serif;padding:40px;background:#fff3cd;border:1px solid #ffc107;border-radius:8px;margin:20px;">
        <h2>⚠️ Database Connection Failed</h2>
        <p>Please ensure MySQL is running and run <a href="/furniture-store/setup/install.php">setup/install.php</a> first.</p>
        <p><code>' . $conn->connect_error . '</code></p>
    </div>');
}

$conn->set_charset("utf8mb4");
