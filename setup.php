<?php
// ============================================================
// UDAAN Carpooling — Database Setup & Seed Script
// Compatible with team's schema from:
//   database/schema.sql + database/seed.sql
//
// Run ONCE in browser: http://localhost/CarPooling/setup.php
// This script runs the team's schema.sql then seed.sql
// AND adds our UDAAN demo users with real passwords.
// ============================================================

$host   = 'localhost';
$user   = 'root';       // ← Change to your MySQL username
$pass   = '';           // ← Change to your MySQL password
$dbName = 'carpooling_platform';

$log = [];

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // ── 1. Create database ─────────────────────────────────
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbName`");
    $log[] = "✅ Database <b>$dbName</b> created / verified.";

    // ── 2. Run team's schema.sql ───────────────────────────
    $schemaFile = __DIR__ . '/database/schema.sql';
    if (file_exists($schemaFile)) {
        $schema = file_get_contents($schemaFile);
        // Remove USE statement — already selected DB above
        $schema = preg_replace('/^\s*USE\s+\S+;\s*$/m', '', $schema);
        // Remove CREATE DATABASE statement
        $schema = preg_replace('/^\s*CREATE\s+DATABASE.*?;\s*$/ms', '', $schema);
        // Split into individual statements
        $statements = array_filter(array_map('trim', explode(';', $schema)));
        foreach ($statements as $stmt) {
            if ($stmt) $pdo->exec($stmt);
        }
        $log[] = "✅ Team schema (<code>database/schema.sql</code>) executed successfully.";
    } else {
        $log[] = "⚠️ <code>database/schema.sql</code> not found — creating minimal UDAAN schema instead.";
        // Fallback: Create minimal schema compatible with UDAAN APIs
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `organizations` (
                `id`                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `name`                VARCHAR(150) NOT NULL,
                `domain`              VARCHAR(150) NOT NULL UNIQUE,
                `fuel_cost_per_km`    DECIMAL(6,2) NOT NULL DEFAULT 10.00,
                `default_fare_per_km` DECIMAL(6,2) NOT NULL DEFAULT 8.00,
                `created_at`          TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `users` (
                `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `org_id`        INT UNSIGNED NOT NULL DEFAULT 1,
                `name`          VARCHAR(100) NOT NULL,
                `email`         VARCHAR(150) NOT NULL UNIQUE,
                `phone`         VARCHAR(15) NOT NULL DEFAULT '0000000000',
                `password_hash` VARCHAR(255) NOT NULL,
                `role`          ENUM('employee','admin') NOT NULL DEFAULT 'employee',
                `profile_photo` VARCHAR(255) NULL,
                `status`        ENUM('active','inactive') NOT NULL DEFAULT 'active',
                `wallet_balance` DECIMAL(10,2) NOT NULL DEFAULT 500.00,
                `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `rides` (
                `id`             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `driver_id`      INT UNSIGNED NOT NULL,
                `start_location` VARCHAR(200) NOT NULL,
                `dest_location`  VARCHAR(200) NOT NULL,
                `travel_time`    DATETIME NOT NULL,
                `seats`          TINYINT UNSIGNED NOT NULL DEFAULT 3,
                `fare`           DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                `status`         ENUM('active','completed','cancelled') NOT NULL DEFAULT 'active',
                `created_at`     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `bookings` (
                `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `ride_id`      INT UNSIGNED NOT NULL,
                `passenger_id` INT UNSIGNED NOT NULL,
                `status`       ENUM('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'confirmed',
                `booked_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `wallets` (
                `id`      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT UNSIGNED NOT NULL UNIQUE,
                `balance` DECIMAL(10,2) NOT NULL DEFAULT 500.00,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
        $log[] = "✅ Minimal UDAAN schema created.";
    }

    // ── 3. Run team's seed.sql ─────────────────────────────
    $seedFile = __DIR__ . '/database/seed.sql';
    if (file_exists($seedFile)) {
        $seed = file_get_contents($seedFile);
        $seed = preg_replace('/^\s*USE\s+\S+;\s*$/m', '', $seed);
        $statements = array_filter(array_map('trim', explode(';', $seed)));
        foreach ($statements as $stmt) {
            if ($stmt) {
                try { $pdo->exec($stmt); } catch (PDOException $e) { /* skip duplicate seed rows */ }
            }
        }
        $log[] = "✅ Team seed data (<code>database/seed.sql</code>) loaded.";
    } else {
        $log[] = "ℹ️ <code>database/seed.sql</code> not found — skipping team seed.";
    }

    // ── 4. Ensure org exists ───────────────────────────────
    $orgCount = $pdo->query("SELECT COUNT(*) FROM organizations")->fetchColumn();
    if ($orgCount == 0) {
        $pdo->exec("INSERT INTO organizations (name, domain) VALUES ('UDAAN Demo Org', 'udaan.com')");
        $log[] = "✅ Default organization created.";
    }

    // ── 5. Add UDAAN demo users (with real bcrypt passwords) ──
    $demoUsers = [
        [1, 'Arjun Mehta',  'driver@udaan.com',    '9876543210', password_hash('password', PASSWORD_DEFAULT), 'employee', 1200.00],
        [2, 'Priya Sharma', 'passenger@udaan.com', '9123456789', password_hash('password', PASSWORD_DEFAULT), 'employee', 850.00],
        [1, 'Admin UDAAN',  'admin@udaan.com',     '9000000001', password_hash('password', PASSWORD_DEFAULT), 'admin',    500.00],
    ];
    $insertedUsers = 0;
    foreach ($demoUsers as [$orgId, $name, $email, $phone, $hash, $role, $balance]) {
        $exists = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $exists->execute([$email]);
        if (!$exists->fetch()) {
            $ins = $pdo->prepare("INSERT INTO users (org_id, name, email, phone, password_hash, role) VALUES (?, ?, ?, ?, ?, ?)");
            $ins->execute([$orgId, $name, $email, $phone, $hash, $role]);
            $userId = $pdo->lastInsertId();

            // Create wallet entry if wallets table exists
            try {
                $pdo->prepare("INSERT IGNORE INTO wallets (user_id, balance) VALUES (?, ?)")->execute([$userId, $balance]);
            } catch(PDOException $e) {}

            $insertedUsers++;
        }
    }
    if ($insertedUsers > 0) {
        $log[] = "✅ Added $insertedUsers UDAAN demo users. Login: <b>driver@udaan.com</b> / <b>passenger@udaan.com</b> (password: <code>password</code>)";
    } else {
        $log[] = "ℹ️ UDAAN demo users already exist.";
    }

    // ── 6. Seed demo rides ─────────────────────────────────
    // Find driver user id
    $driverStmt = $pdo->prepare("SELECT id FROM users WHERE email = 'driver@udaan.com' LIMIT 1");
    $driverStmt->execute();
    $driver = $driverStmt->fetch();
    $driverId = $driver ? $driver['id'] : 1;

    $rideCount = $pdo->query("SELECT COUNT(*) FROM rides")->fetchColumn();
    if ($rideCount < 4) {
        $t1 = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $t2 = date('Y-m-d H:i:s', strtotime('+2 hours'));
        $t3 = date('Y-m-d H:i:s', strtotime('+3 hours'));
        $t4 = date('Y-m-d H:i:s', strtotime('+90 minutes'));
        $ins = $pdo->prepare("INSERT INTO rides (driver_id, start_location, dest_location, travel_time, seats, fare, status) VALUES (?,?,?,?,?,?,'active')");
        $ins->execute([$driverId, 'ISKCON Temple, Ahmedabad',  'Infocity, Gandhinagar',       $t1, 3, 120.00]);
        $ins->execute([$driverId, 'Satellite Road, Ahmedabad', 'Science City, Ahmedabad',     $t2, 2, 80.00]);
        $ins->execute([$driverId, 'Maninagar, Ahmedabad',      'Naroda GIDC, Ahmedabad',      $t3, 4, 60.00]);
        $ins->execute([$driverId, 'SG Highway, Ahmedabad',     'Gandhinagar Secretariat',     $t4, 1, 150.00]);
        $log[] = "✅ Seeded 4 demo rides.";
    } else {
        $log[] = "ℹ️ Rides already exist — skipped.";
    }

    $log[] = "🚀 <b>Setup complete!</b> Open <a href='index.html'>index.html</a> to launch the app.";

} catch (PDOException $e) {
    $log[] = "❌ ERROR: " . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UDAAN — DB Setup</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: system-ui, sans-serif; background: #0f172a; color: #e2e8f0; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
  .card { background: #1e293b; border: 1px solid #334155; border-radius: 16px; padding: 40px; max-width: 600px; width: 100%; box-shadow: 0 25px 50px rgba(0,0,0,.5); }
  .logo { font-size: 2rem; font-weight: 800; background: linear-gradient(135deg, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 8px; }
  .sub { color: #64748b; margin-bottom: 28px; font-size: 0.9rem; }
  .log-item { padding: 10px 14px; margin-bottom: 8px; border-radius: 8px; background: #0f172a; font-size: 0.875rem; line-height: 1.6; }
  .log-item a, .log-item code, .log-item b { color: #38bdf8; }
  .log-item code { font-family: monospace; }
</style>
</head>
<body>
<div class="card">
  <div class="logo">🚗 UDAAN Setup</div>
  <div class="sub">Database initialisation log — Team Carpooling Platform</div>
  <?php foreach ($log as $line): ?>
    <div class="log-item"><?= $line ?></div>
  <?php endforeach; ?>
</div>
</body>
</html>
