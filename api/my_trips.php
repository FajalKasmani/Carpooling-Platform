<?php
// ============================================================
// api/my_trips.php — Returns trips/bookings for a passenger
// Team schema: bookings table (fallback: trips table)
// GET ?passenger_id=2
// ============================================================
session_start();
require_once '../config.php';

$passengerId = (int)($_GET['passenger_id'] ?? $_SESSION['user_id'] ?? 0);
if (!$passengerId) {
    echo json_encode(['success' => false, 'error' => 'passenger_id required']);
    exit;
}

$pdo = getDB();

// Detect which table name team uses
function tableExists(PDO $pdo, string $table): bool {
    try { $pdo->query("SELECT 1 FROM `$table` LIMIT 1"); return true; }
    catch (PDOException $e) { return false; }
}

$bookTable = tableExists($pdo, 'bookings') ? 'bookings' : 'trips';

$stmt = $pdo->prepare("
    SELECT b.id AS trip_id, b.status AS trip_status, b.booked_at,
           r.start_location, r.dest_location, r.travel_time, r.fare,
           u.name AS driver_name
    FROM $bookTable b
    JOIN rides r ON r.id = b.ride_id
    JOIN users u ON u.id = r.driver_id
    WHERE b.passenger_id = ?
    ORDER BY b.booked_at DESC
    LIMIT 30
");
$stmt->execute([$passengerId]);
$trips = $stmt->fetchAll();

// Add emoji avatars
$emojis = ['🧑','👩','👨','🧕'];
foreach ($trips as &$t) {
    $t['driver_avatar'] = $emojis[abs(crc32($t['driver_name'])) % count($emojis)];
}
unset($t);

echo json_encode(['success' => true, 'trips' => $trips, 'count' => count($trips)]);
