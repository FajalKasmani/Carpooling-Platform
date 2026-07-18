<?php
// ============================================================
// api/book_ride.php — Book a ride
// Team schema: uses 'bookings' table (not 'trips')
// Wallet deduction from 'wallets' table
// POST { ride_id, passenger_id }
// ============================================================
session_start();
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'POST required']);
    exit;
}

$body         = json_decode(file_get_contents('php://input'), true) ?? [];
$ride_id      = (int)($body['ride_id']      ?? 0);
$passenger_id = (int)($body['passenger_id'] ?? $_SESSION['user_id'] ?? 0);

if (!$ride_id || !$passenger_id) {
    echo json_encode(['success' => false, 'error' => 'ride_id and passenger_id are required']);
    exit;
}

$pdo = getDB();
$pdo->beginTransaction();

try {
    // 1. Fetch ride with lock
    $stmt = $pdo->prepare("SELECT * FROM rides WHERE id = ? AND status = 'active' FOR UPDATE");
    $stmt->execute([$ride_id]);
    $ride = $stmt->fetch();

    if (!$ride) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'error' => 'Ride not found or no longer active']);
        exit;
    }

    // 2. Determine bookings table name (team = bookings, fallback = trips)
    $bookingsTable = tableExists($pdo, 'bookings') ? 'bookings' : 'trips';
    $passengerCol  = 'passenger_id';

    // 3. Check already booked
    $dup = $pdo->prepare("SELECT id FROM $bookingsTable WHERE ride_id = ? AND $passengerCol = ? AND status != 'cancelled'");
    $dup->execute([$ride_id, $passenger_id]);
    if ($dup->fetch()) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'error' => 'You have already booked this ride']);
        exit;
    }

    // 4. Check seat availability
    $bookedStmt = $pdo->prepare("SELECT COUNT(*) FROM $bookingsTable WHERE ride_id = ? AND status != 'cancelled'");
    $bookedStmt->execute([$ride_id]);
    $bookedCount = (int)$bookedStmt->fetchColumn();
    if ($bookedCount >= (int)$ride['seats']) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'error' => 'No seats available on this ride']);
        exit;
    }

    $fare = (float)$ride['fare'];

    // 5. Check wallet — team uses wallets table, fallback to users.wallet_balance
    $walletBalance = getWalletBalance($pdo, $passenger_id);
    if ($walletBalance < $fare) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'error' => "Insufficient balance. Have ₹$walletBalance, need ₹$fare"]);
        exit;
    }

    // 6. Insert booking
    $insSQL = "INSERT INTO $bookingsTable (ride_id, $passengerCol, status) VALUES (?, ?, 'confirmed')";
    $ins    = $pdo->prepare($insSQL);
    $ins->execute([$ride_id, $passenger_id]);
    $bookingId = $pdo->lastInsertId();

    // 7. Deduct from passenger wallet
    deductWallet($pdo, $passenger_id, $fare);

    // 8. Credit driver wallet
    creditWallet($pdo, $ride['driver_id'], $fare);

    $pdo->commit();

    $newBalance = $walletBalance - $fare;
    echo json_encode([
        'success'     => true,
        'message'     => 'Ride booked successfully! 🎉',
        'booking_id'  => $bookingId,
        'fare'        => $fare,
        'new_balance' => round($newBalance, 2),
        'ride'        => [
            'from' => $ride['start_location'],
            'to'   => $ride['dest_location'],
            'time' => $ride['travel_time'],
        ]
    ]);

} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => 'Booking failed: ' . $e->getMessage()]);
}

// ── Helpers ────────────────────────────────────────────────
function tableExists(PDO $pdo, string $table): bool {
    try {
        $pdo->query("SELECT 1 FROM `$table` LIMIT 1");
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function getWalletBalance(PDO $pdo, int $userId): float {
    // Try team's wallets table first
    if (tableExists($pdo, 'wallets')) {
        $s = $pdo->prepare("SELECT balance FROM wallets WHERE user_id = ?");
        $s->execute([$userId]);
        $row = $s->fetch();
        if ($row !== false) return (float)$row['balance'];
        // Create wallet entry if missing
        $pdo->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, 500.00)")->execute([$userId]);
        return 500.00;
    }
    // Fallback: users.wallet_balance
    $s = $pdo->prepare("SELECT wallet_balance FROM users WHERE id = ?");
    $s->execute([$userId]);
    return (float)($s->fetchColumn() ?? 0);
}

function deductWallet(PDO $pdo, int $userId, float $amount): void {
    if (tableExists($pdo, 'wallets')) {
        $pdo->prepare("UPDATE wallets SET balance = balance - ? WHERE user_id = ?")->execute([$amount, $userId]);
    } else {
        $pdo->prepare("UPDATE users SET wallet_balance = wallet_balance - ? WHERE id = ?")->execute([$amount, $userId]);
    }
}

function creditWallet(PDO $pdo, int $userId, float $amount): void {
    if (tableExists($pdo, 'wallets')) {
        // Upsert wallet entry for driver
        $exists = $pdo->prepare("SELECT id FROM wallets WHERE user_id = ?");
        $exists->execute([$userId]);
        if ($exists->fetch()) {
            $pdo->prepare("UPDATE wallets SET balance = balance + ? WHERE user_id = ?")->execute([$amount, $userId]);
        } else {
            $pdo->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, ?)")->execute([$userId, $amount]);
        }
    } else {
        $pdo->prepare("UPDATE users SET wallet_balance = wallet_balance + ? WHERE id = ?")->execute([$amount, $userId]);
    }
}
