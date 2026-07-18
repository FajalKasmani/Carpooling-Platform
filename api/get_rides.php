<?php
// ============================================================
// api/get_rides.php — Returns available rides as JSON
// Team schema: rides table (same column names — compatible)
// GET ?start=&dest=  (optional filters)
// ============================================================
session_start();
require_once '../config.php';

$start = trim($_GET['start'] ?? '');
$dest  = trim($_GET['dest']  ?? '');

$pdo = getDB();

// Build query — team schema uses 'users' with 'name' col
$sql = "
    SELECT r.id, r.start_location, r.dest_location, r.travel_time,
           r.seats, r.fare, r.status,
           u.id AS driver_id, u.name AS driver_name,
           u.phone AS driver_phone
    FROM rides r
    JOIN users u ON u.id = r.driver_id
    WHERE r.status = 'active'
      AND r.seats > 0
      AND u.status = 'active'
";
$params = [];

if ($start !== '') {
    $sql    .= " AND r.start_location LIKE ?";
    $params[] = "%$start%";
}
if ($dest !== '') {
    $sql    .= " AND r.dest_location LIKE ?";
    $params[] = "%$dest%";
}

$sql .= " ORDER BY r.travel_time ASC LIMIT 50";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rides = $stmt->fetchAll();

// Count booked seats using team's 'bookings' table
// (team schema: bookings table is equivalent to our trips table)
foreach ($rides as &$ride) {
    // Try team's bookings table first, fallback to trips
    try {
        $s = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE ride_id = ? AND status NOT IN ('cancelled')");
        $s->execute([$ride['id']]);
    } catch (PDOException $e) {
        try {
            $s = $pdo->prepare("SELECT COUNT(*) FROM trips WHERE ride_id = ? AND status != 'cancelled'");
            $s->execute([$ride['id']]);
        } catch (PDOException $e2) {
            // no bookings table yet
        }
    }
    $booked                  = isset($s) ? (int)$s->fetchColumn() : 0;
    $ride['booked']          = $booked;
    $ride['available_seats'] = max(0, (int)$ride['seats'] - $booked);
    $ride['fare']            = (float)$ride['fare'];
    // Generate avatar emoji from driver name
    $emojis = ['🧑','👩','👨','🧕'];
    $ride['driver_avatar'] = $emojis[abs(crc32($ride['driver_name'])) % count($emojis)];
}
unset($ride);

echo json_encode(['success' => true, 'rides' => $rides, 'count' => count($rides)]);
