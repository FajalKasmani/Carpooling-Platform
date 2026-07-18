<?php
// ============================================================
// api/offer_ride.php — Driver publishes a new ride
// POST { start_location, dest_location, travel_time, seats, fare }
// ============================================================
session_start();
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'POST required']);
    exit;
}

$body  = json_decode(file_get_contents('php://input'), true) ?? [];
$driverId = (int)($body['driver_id'] ?? $_SESSION['user_id'] ?? 1); // default to user 1 for demo

$start = trim($body['start_location'] ?? '');
$dest  = trim($body['dest_location']  ?? '');
$time  = trim($body['travel_time']    ?? '');
$seats = (int)($body['seats']         ?? 1);
$fare  = (float)($body['fare']        ?? 0);

if (!$start || !$dest || !$time || $seats < 1 || $fare < 0) {
    echo json_encode(['success' => false, 'error' => 'All fields are required']);
    exit;
}

$pdo  = getDB();
$stmt = $pdo->prepare("
    INSERT INTO rides (driver_id, start_location, dest_location, travel_time, seats, fare, status)
    VALUES (?, ?, ?, ?, ?, ?, 'active')
");
$stmt->execute([$driverId, $start, $dest, $time, $seats, $fare]);
$rideId = $pdo->lastInsertId();

echo json_encode([
    'success' => true,
    'message' => 'Ride published successfully!',
    'ride_id' => $rideId,
]);
