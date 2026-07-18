<?php
/**
 * Application Configuration
 * Loaded once by public/index.php before routing.
 */

// ── Load .env file ────────────────────────────────────────
$envFile = dirname(__DIR__, 2) . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (str_contains($line, '=')) {
            [$key, $value] = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value);
            $_ENV[$key]    = $value;
            putenv("{$key}={$value}");
        }
    }
}

// ── Timezone ──────────────────────────────────────────────
date_default_timezone_set('Asia/Kolkata');

// ── Error handling ────────────────────────────────────────
$debug = ($_ENV['APP_DEBUG'] ?? 'false') === 'true';

if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// ── Custom exception handler ──────────────────────────────
set_exception_handler(function (\Throwable $e) use ($debug) {
    $logDir = dirname(__DIR__, 2) . '/storage/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $logMessage = sprintf(
        "[%s] %s in %s:%d\n%s\n\n",
        date('Y-m-d H:i:s'),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString()
    );
    file_put_contents($logDir . '/app.log', $logMessage, FILE_APPEND);

    http_response_code(500);

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json')) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error'   => $debug ? $e->getMessage() : 'Internal Server Error',
        ]);
    } else {
        echo '<h1>500 — Internal Server Error</h1>';
        if ($debug) {
            echo '<pre>' . htmlspecialchars($e->getMessage()) . "\n" . htmlspecialchars($e->getTraceAsString()) . '</pre>';
        }
    }
    exit;
});

// ── CORS headers (for development AJAX) ───────────────────
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
