<?php
// ============================================================
// api/wallet.php — Wallet info & top-up
// Team schema: wallets table (user_id, balance)
// GET ?user_id=   → returns balance + recent bookings as history
// POST { user_id, amount } → credits wallet
// ============================================================
session_start();
require_once '../config.php';

$pdo = getDB();

function tableExists(PDO $pdo, string $table): bool {
    try { $pdo->query("SELECT 1 FROM `$table` LIMIT 1"); return true; }
    catch (PDOException $e) { return false; }
}

function getBalance(PDO $pdo, int $userId): float {
    if (tableExists($pdo, 'wallets')) {
        $s = $pdo->prepare("SELECT balance FROM wallets WHERE user_id = ?");
        $s->execute([$userId]);
        $row = $s->fetch();
        if ($row === false) {
            $pdo->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, 500.00)")->execute([$userId]);
            return 500.00;
        }
        return (float)$row['balance'];
    }
    $s = $pdo->prepare("SELECT wallet_balance FROM users WHERE id = ?");
    $s->execute([$userId]);
    return (float)($s->fetchColumn() ?? 500);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = (int)($_GET['user_id'] ?? $_SESSION['user_id'] ?? 0);
    if (!$userId) { echo json_encode(['success'=>false,'error'=>'user_id required']); exit; }

    $balance = getBalance($pdo, $userId);

    // Transaction history from bookings (or trips) table
    $history = [];
    $histTable = tableExists($pdo, 'bookings') ? 'bookings' : (tableExists($pdo, 'trips') ? 'trips' : null);
    if ($histTable) {
        $hist = $pdo->prepare("
            SELECT b.booked_at AS date, r.fare AS amount,
                   CONCAT('Ride to ', r.dest_location) AS description, 'debit' AS type
            FROM $histTable b
            JOIN rides r ON r.id = b.ride_id
            WHERE b.passenger_id = ? AND b.status != 'cancelled'
            ORDER BY b.booked_at DESC LIMIT 8
        ");
        $hist->execute([$userId]);
        $history = $hist->fetchAll();
    }

    echo json_encode(['success' => true, 'balance' => $balance, 'history' => $history]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body   = json_decode(file_get_contents('php://input'), true) ?? [];
    $userId = (int)($body['user_id'] ?? $_SESSION['user_id'] ?? 0);
    $amount = (float)($body['amount'] ?? 0);
    if (!$userId || $amount <= 0) { echo json_encode(['success'=>false,'error'=>'Invalid params']); exit; }

    if (tableExists($pdo, 'wallets')) {
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

    $newBalance = getBalance($pdo, $userId);
    echo json_encode(['success' => true, 'message' => "₹$amount added!", 'new_balance' => $newBalance]);
    exit;
}

echo json_encode(['success' => false, 'error' => 'Invalid request method']);
