<?php
// ============================================================
// UDAAN Carpooling Platform — Database Configuration
// Adapted to team's schema: carpooling_platform DB
// ============================================================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // ← Change to your MySQL username
define('DB_PASS', '');           // ← Change to your MySQL password
define('DB_NAME', 'carpooling_platform');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            die(json_encode(['success' => false, 'error' => 'DB Connection failed: ' . $e->getMessage()]));
        }
    }
    return $pdo;
}

// Allow CORS for local SPA calls
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
header('Content-Type: application/json');
