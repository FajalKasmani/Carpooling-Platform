<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) . ' — RideShare' : 'RideShare' ?></title>

    <link rel="icon" type="image/svg+xml" href="<?= $baseUrl ?>/favicon.svg">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Fonts: Outfit + Inter + JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- GSAP -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <!-- Design System -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
</head>
<?php
$isAdminMode = (strpos($_SERVER['REQUEST_URI'] ?? '', '/admin') !== false);
?>
<body class="d-flex flex-column h-100 <?= $isAdminMode ? 'admin-mode' : '' ?>">

    <!-- Mobile Top Navbar -->
    <nav class="navbar mobile-topnav d-lg-none sticky-top px-3" style="min-height:52px;">
        <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="<?= $baseUrl ?>/dashboard"
           style="font-family:'Outfit',sans-serif;font-weight:700;font-size:15px;color:var(--text);letter-spacing:-0.02em;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6C63FF" stroke-width="1.8">
                <path d="M3 16c3-6 5-9 9-9s6 3 9 9" stroke-linecap="round"/>
                <circle cx="6" cy="18" r="1.4" fill="#6C63FF" stroke="none"/>
                <circle cx="18" cy="18" r="1.4" fill="#00D4AA" stroke="none"/>
            </svg>
            RideShare
        </a>
        <button class="border-0 bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavbar"
                style="color:var(--text-muted);font-size:1.25rem;">
            <i class="bi bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="mobileNavbar"
             style="background:var(--bg-soft);border-radius:12px;margin-top:8px;padding:0.5rem;border:1px solid var(--border-md);">
            <ul class="list-unstyled mb-0">
                <?php
                $mobileLinks = [
                    ['dashboard', 'bi-house-door', 'Dashboard'],
                    ['find-ride', 'bi-search', 'Find Ride'],
                    ['offer-ride', 'bi-plus-circle', 'Offer Ride'],
                    ['my-trips', 'bi-calendar-event', 'My Trips'],
                    ['wallet', 'bi-wallet2', 'Wallet'],
                    ['vehicles', 'bi-car-front', 'Vehicles'],
                ];
                foreach ($mobileLinks as [$route, $icon, $label]): ?>
                <li>
                    <a class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none"
                       href="<?= $baseUrl ?>/<?= $route ?>"
                       style="font-size:13px;font-weight:500;color:var(--text-muted);transition:color .15s;">
                        <i class="bi <?= $icon ?>"></i> <?= $label ?>
                    </a>
                </li>
                <?php endforeach; ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li>
                    <a class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none"
                       href="<?= $baseUrl ?>/admin/dashboard"
                       style="font-size:13px;font-weight:600;color:var(--teal);">
                        <i class="bi bi-shield-lock"></i> Admin Panel
                    </a>
                </li>
                <?php endif; ?>
                <li style="border-top:1px solid var(--border);margin-top:4px;padding-top:4px;">
                    <a class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none"
                       href="<?= $baseUrl ?>/logout"
                       style="font-size:13px;font-weight:500;color:var(--red);">
                        <i class="bi bi-box-arrow-right"></i> Sign Out
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- App Shell -->
    <div class="container-fluid flex-grow-1 d-flex p-0">
        <div class="row g-0 flex-grow-1">
