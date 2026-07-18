<?php
// ============================================================
// api/auth.php — Login / Session Management
// Team schema: users.password_hash, users.org_id
// POST { email, password } → sets session, returns user JSON
// GET  ?whoami=1           → returns current session user
// GET  ?logout=1           → destroys session
// Demo: driver@udaan.com | passenger@udaan.com  (pass: password)
// ============================================================
session_start();
require_once '../config.php';

// ── WHO AM I ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['whoami'])) {
    if (isset($_SESSION['user_id'])) {
        $pdo  = getDB();
        $stmt = $pdo->prepare("
            SELECT u.id, u.name, u.email, u.role, u.phone, u.profile_photo,
                   COALESCE(w.balance, 500) AS wallet_balance,
                   o.name AS org_name
            FROM users u
            LEFT JOIN wallets w ON w.user_id = u.id
            LEFT JOIN organizations o ON o.id = u.org_id
            WHERE u.id = ?
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        if ($user) {
            $user['avatar'] = getAvatar($user['name']);
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'error' => 'User not found']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Not logged in']);
    }
    exit;
}

// ── LOGOUT ────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['logout'])) {
    session_destroy();
    echo json_encode(['success' => true, 'message' => 'Logged out']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'POST required']);
    exit;
}

$body     = json_decode(file_get_contents('php://input'), true) ?? [];
$email    = trim($body['email']    ?? '');
$password = trim($body['password'] ?? '');

if (!$email || !$password) {
    echo json_encode(['success' => false, 'error' => 'Email and password are required']);
    exit;
}

$pdo  = getDB();
$stmt = $pdo->prepare("
    SELECT u.id, u.name, u.email, u.password_hash, u.role, u.phone, u.profile_photo,
           COALESCE(w.balance, 500) AS wallet_balance,
           o.name AS org_name
    FROM users u
    LEFT JOIN wallets w ON w.user_id = u.id
    LEFT JOIN organizations o ON o.id = u.org_id
    WHERE u.email = ? AND u.status = 'active'
");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password_hash'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
    exit;
}

$_SESSION['user_id'] = $user['id'];
unset($user['password_hash']);
$user['avatar'] = getAvatar($user['name']);

echo json_encode(['success' => true, 'user' => $user]);

// ── Helper ────────────────────────────────────────────────
function getAvatar(string $name): string {
    $emojis = ['🧑','👩','👨','🧕','👲','👳'];
    return $emojis[abs(crc32($name)) % count($emojis)];
}
