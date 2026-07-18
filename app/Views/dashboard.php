<?php
$title = "Dashboard";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard</h1>
    <div class="text-muted fw-medium fs-6" id="current-time"></div>
</div>

<!-- Welcome Alert Banner -->
<div class="card border-0 bg-primary text-white shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 100%) !important;">
    <div class="card-body p-4 p-md-5">
        <h2 class="fw-bold mb-2">Hello, <span id="dash-user-name"><?= htmlspecialchars($_SESSION['user_name']) ?></span>!</h2>
        <p class="fs-5 opacity-90 mb-4">Start your eco-friendly commute today. Save travel costs, network with colleagues, and reduce your carbon footprint.</p>
        <div class="d-flex gap-3 flex-wrap">
            <a href="<?= $baseUrl ?>/find-ride" class="btn btn-light btn-lg fw-semibold px-4 rounded-3 text-primary shadow-sm"><i class="bi bi-search me-2"></i>Find a Ride</a>
            <a href="<?= $baseUrl ?>/offer-ride" class="btn btn-outline-light btn-lg fw-semibold px-4 rounded-3"><i class="bi bi-plus-circle me-2"></i>Offer a Ride</a>
        </div>
    </div>
</div>

<!-- Key Stat Widgets -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 mb-4">
    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3 fs-3">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Wallet Balance</h6>
                    <h4 class="fw-bold mb-0 text-dark">₹<span id="dash-wallet-balance">0.00</span></h4>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center">
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3 fs-3">
                    <i class="bi bi-tree-fill"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">CO₂ Saved</h6>
                    <h4 class="fw-bold mb-0 text-success"><span id="dash-co2-saved">0</span> kg</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center">
                <div class="bg-info bg-opacity-10 text-info p-3 rounded-3 me-3 fs-3">
                    <i class="bi bi-compass"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Total Shared KM</h6>
                    <h4 class="fw-bold mb-0 text-dark"><span id="dash-distance-km">0</span> km</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 me-3 fs-3">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">My Vehicles</h6>
                    <h4 class="fw-bold mb-0 text-dark"><span id="dash-vehicles-count">0</span></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Trip Widget -->
<div class="row mb-4">
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Upcoming Journey</h5>
                <a href="<?= $baseUrl ?>/my-trips" class="text-decoration-none fw-semibold">View All Trips</a>
            </div>
            <div class="card-body p-4" id="upcoming-trip-card">
                <div class="text-center text-muted py-5">
                    <i class="bi bi-calendar3 fs-1 mb-3 text-secondary"></i>
                    <p class="mb-0">No upcoming rides scheduled.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-xl-4">
        <!-- Quick Action Sidebar Panel inside Dashboard -->
        <div class="card border-0 bg-dark text-white shadow-sm rounded-4 h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="fw-bold mb-3"><i class="bi bi-lightning-charge-fill me-2 text-warning"></i>Quick Actions</h5>
                    <p class="text-muted" style="font-size: 0.9rem;">Quickly check your routes, manage your registered vehicles, or add money to your wallet instantly.</p>
                </div>
                <div class="d-grid gap-2">
                    <a href="<?= $baseUrl ?>/wallet" class="btn btn-outline-light d-flex align-items-center justify-content-between py-2 px-3 rounded-3">
                        <span><i class="bi bi-wallet2 me-2 text-info"></i>Top Up Wallet</span>
                        <i class="bi bi-chevron-right fs-7 text-muted"></i>
                    </a>
                    <a href="<?= $baseUrl ?>/vehicles" class="btn btn-outline-light d-flex align-items-center justify-content-between py-2 px-3 rounded-3">
                        <span><i class="bi bi-car-front me-2 text-success"></i>Manage Vehicles</span>
                        <i class="bi bi-chevron-right fs-7 text-muted"></i>
                    </a>
                    <a href="<?= $baseUrl ?>/reports" class="btn btn-outline-light d-flex align-items-center justify-content-between py-2 px-3 rounded-3">
                        <span><i class="bi bi-bar-chart-line me-2 text-warning"></i>View Analytics</span>
                        <i class="bi bi-chevron-right fs-7 text-muted"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= $baseUrl ?>/assets/js/dashboard.js"></script>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
