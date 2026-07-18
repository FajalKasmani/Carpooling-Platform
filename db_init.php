<?php
// ============================================================
// UDAAN Carpooling Platform — Automatic Database Initialiser
// Run in browser: http://localhost/CarPooling/db_init.php
// ============================================================

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load environment config if exists
$envFile = __DIR__ . '/.env';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'carpooling_platform';

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        if (str_contains($line, '=')) {
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if ($key === 'DB_HOST') $db_host = $value;
            if ($key === 'DB_USER') $db_user = $value;
            if ($key === 'DB_PASS') $db_pass = $value;
            if ($key === 'DB_NAME') $db_name = $value;
        }
    }
}

$log = [];

try {
    // 1. Connect to MySQL Server
    $pdo = new PDO("mysql:host={$db_host};charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $log[] = "✅ Connected to MySQL server at <code>{$db_host}</code> successfully.";

    // 2. Create Database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `{$db_name}`");
    $log[] = "✅ Database <code>{$db_name}</code> created / verified.";

    // 3. Import Schema
    $schemaFile = __DIR__ . '/database/schema.sql';
    if (file_exists($schemaFile)) {
        $schema = file_get_contents($schemaFile);
        
        // Split statements by semicolon, avoiding inside triggers or strings
        $statements = array_filter(array_map('trim', explode(';', $schema)));
        foreach ($statements as $stmt) {
            if ($stmt) {
                $pdo->exec($stmt);
            }
        }
        $log[] = "✅ Database schema loaded successfully from <code>database/schema.sql</code>.";
    } else {
        throw new Exception("Schema file not found at database/schema.sql");
    }

    // 4. Import Seed
    $seedFile = __DIR__ . '/database/seed.sql';
    if (file_exists($seedFile)) {
        $seed = file_get_contents($seedFile);
        $statements = array_filter(array_map('trim', explode(';', $seed)));
        foreach ($statements as $stmt) {
            if ($stmt) {
                try {
                    $pdo->exec($stmt);
                } catch (PDOException $e) {
                    // Ignore duplicate key errors if already seeded
                    if ($e->getCode() != 23000) {
                        throw $e;
                    }
                }
            }
        }
        $log[] = "✅ Seed demo data loaded successfully from <code>database/seed.sql</code>.";
    } else {
        $log[] = "ℹ️ Seed file not found at database/seed.sql - skipped.";
    }

    $log[] = "🚀 <b>Setup complete!</b> Open <a href='public/'>http://localhost/CarPooling/public/</a> to launch the app.";

} catch (Exception $e) {
    $log[] = "❌ <b>Setup Error:</b> " . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UDAAN — DB Initialization</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #0f172a; color: #e2e8f0; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 20px; }
        .card { background: #1e293b; border: 1px solid #334155; border-radius: 16px; padding: 30px; max-width: 600px; width: 100%; box-shadow: 0 25px 50px rgba(0,0,0,.5); }
        .logo { font-size: 1.8rem; font-weight: 800; background: linear-gradient(135deg, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 20px; }
        .log-item { padding: 12px; margin-bottom: 8px; border-radius: 8px; background: #0f172a; font-size: 0.9rem; line-height: 1.5; }
        .log-item a, .log-item code, .log-item b { color: #38bdf8; text-decoration: none; }
        .log-item a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">🚗 UDAAN — Database Setup</div>
        <?php foreach ($log as $line): ?>
            <div class="log-item"><?= $line ?></div>
        <?php endforeach; ?>
    </div>
</body>
</html>
