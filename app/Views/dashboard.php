<?php
$title = "Dashboard";
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/layouts/sidebar.php';
?>

<!-- Page Header -->
<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon">
            <i class="bi bi-speedometer2"></i>
        </span>
        Dashboard
    </div>
    <div class="mono" id="current-time" style="font-size:13px;color:var(--text-muted);"></div>
</div>

<!-- Hero Banner -->
<div class="hero-banner reveal mb-4" style="animation-delay:.05s">
    <div style="position:relative;z-index:1;">
        <div style="font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.1em;color:var(--accent);margin-bottom:8px;">
            <i class="bi bi-lightning-charge-fill me-1"></i> Good to see you
        </div>
        <h2 style="font-size:24px;font-weight:700;margin-bottom:8px;font-family:'Outfit',sans-serif;">
            Hello, <span id="dash-user-name" class="text-gradient"><?= htmlspecialchars($_SESSION['user_name']) ?></span>!
        </h2>
        <p style="font-size:14px;color:var(--text-muted);margin-bottom:24px;max-width:480px;line-height:1.65;">
            Start your eco-friendly commute today. Save travel costs, network with colleagues, and reduce your carbon footprint.
        </p>
        <div class="d-flex gap-3 flex-wrap">
            <a href="<?= $baseUrl ?>/find-ride" class="btn btn-primary">
                <i class="bi bi-search"></i> Find a Ride
            </a>
            <a href="<?= $baseUrl ?>/offer-ride" class="btn btn-glass">
                <i class="bi bi-plus-circle"></i> Offer a Ride
            </a>
        </div>
    </div>
</div>

<!-- Stat Cards -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-4">
    <div class="col reveal" style="animation-delay:.08s">
        <div class="stat-card h-100 p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon accent">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <div class="stat-label">Wallet Balance</div>
                    <div class="stat-value mono">₹<span id="dash-wallet-balance">0.00</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col reveal" style="animation-delay:.11s">
        <div class="stat-card h-100 p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon teal">
                    <i class="bi bi-tree-fill"></i>
                </div>
                <div>
                    <div class="stat-label">CO₂ Saved</div>
                    <div class="stat-value mono"><span id="dash-co2-saved">0</span> <small style="font-size:13px;">kg</small></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col reveal" style="animation-delay:.14s">
        <div class="stat-card h-100 p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon orange">
                    <i class="bi bi-compass"></i>
                </div>
                <div>
                    <div class="stat-label">Total Shared KM</div>
                    <div class="stat-value mono"><span id="dash-distance-km">0</span> <small style="font-size:13px;">km</small></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col reveal" style="animation-delay:.17s">
        <div class="stat-card h-100 p-4">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon green">
                    <i class="bi bi-car-front-fill"></i>
                </div>
                <div>
                    <div class="stat-label">My Vehicles</div>
                    <div class="stat-value mono"><span id="dash-vehicles-count">0</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming + Quick Actions -->
<div class="row g-3 mb-4">
    <div class="col-12 col-xl-8 reveal" style="animation-delay:.2s">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin:0;display:flex;align-items:center;gap:8px;">
                        <span style="width:28px;height:28px;border-radius:8px;background:var(--accent-soft);color:var(--accent);display:inline-flex;align-items:center;justify-content:center;font-size:13px;">
                            <i class="bi bi-clock-history"></i>
                        </span>
                        Upcoming Journey
                    </h5>
                    <a href="<?= $baseUrl ?>/my-trips" style="font-size:12.5px;font-weight:600;color:var(--accent);">View All →</a>
                </div>
                <div id="upcoming-trip-card">
                    <div class="text-center py-5" style="color:var(--text-faint);">
                        <div style="width:52px;height:52px;border-radius:14px;background:var(--bg-soft);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:22px;color:var(--text-faint);">
                            <i class="bi bi-calendar3"></i>
                        </div>
                        <div style="font-size:13.5px;color:var(--text-muted);">No upcoming rides scheduled.</div>
                        <a href="<?= $baseUrl ?>/find-ride" class="btn btn-primary btn-sm mt-3">Find a Ride</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-4 reveal" style="animation-delay:.23s">
        <div class="card h-100" style="background:linear-gradient(145deg,rgba(108,99,255,0.1),rgba(0,212,170,0.05))!important;">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                    <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:10px;display:flex;align-items:center;gap:8px;">
                        <i class="bi bi-lightning-charge-fill" style="color:var(--yellow);"></i> Quick Actions
                    </h5>
                    <p style="font-size:13px;color:var(--text-muted);line-height:1.6;">Quickly check your routes, manage your registered vehicles, or add money to your wallet instantly.</p>
                </div>
                <div class="d-grid gap-2 mt-3">
                    <a href="<?= $baseUrl ?>/wallet" class="btn btn-glass d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-wallet2 me-2" style="color:var(--accent);"></i>Top Up Wallet</span>
                        <i class="bi bi-chevron-right" style="font-size:11px;color:var(--text-faint);"></i>
                    </a>
                    <a href="<?= $baseUrl ?>/vehicles" class="btn btn-glass d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-car-front me-2" style="color:var(--teal);"></i>Manage Vehicles</span>
                        <i class="bi bi-chevron-right" style="font-size:11px;color:var(--text-faint);"></i>
                    </a>
                    <a href="<?= $baseUrl ?>/reports" class="btn btn-glass d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-bar-chart-line me-2" style="color:var(--yellow);"></i>View Analytics</span>
                        <i class="bi bi-chevron-right" style="font-size:11px;color:var(--text-faint);"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= $baseUrl ?>/assets/js/dashboard.js"></script>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>
