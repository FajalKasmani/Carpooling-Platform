<?php
$title = "Available Rides";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon" style="background:var(--teal-soft);color:var(--teal);">
            <i class="bi bi-card-list"></i>
        </span>
        Available Rides
    </div>
    <a href="<?= $baseUrl ?>/find-ride" class="btn btn-glass btn-sm">
        <i class="bi bi-arrow-left"></i> Modify Search
    </a>
</div>

<!-- Search Summary -->
<div class="card p-3 mb-4 reveal" style="animation-delay:.04s;background:var(--accent-soft)!important;border-color:rgba(108,99,255,0.2)!important;">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-geo-alt-fill fs-5" style="color:var(--accent);"></i>
            <div>
                <span style="font-weight:600;color:var(--text);" id="header-pickup">...</span>
                <i class="bi bi-arrow-right mx-2" style="color:var(--text-muted);"></i>
                <span style="font-weight:600;color:var(--text);" id="header-drop">...</span>
            </div>
        </div>
        <div class="d-flex gap-2">
            <span class="badge badge-accent px-3 py-2" id="header-date">...</span>
            <span class="badge badge-accent px-3 py-2" id="header-seats">1 Seat</span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Filter -->
    <div class="col-12 col-xl-3 reveal" style="animation-delay:.07s">
        <div class="card p-4">
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:15px;margin-bottom:18px;display:flex;align-items:center;gap:8px;">
                <i class="bi bi-funnel" style="color:var(--accent);"></i> Filter Matches
            </h5>

            <div class="mb-4">
                <label class="form-label">Sort By</label>
                <select class="form-select" id="sort-filter">
                    <option value="time">Departure Time</option>
                    <option value="fare">Lowest Fare</option>
                    <option value="rating">Driver Rating</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Max Fare: ₹<span id="fare-range-val">500</span></label>
                <input type="range" class="form-range" id="fare-range" min="10" max="500" step="10" value="500">
            </div>

            <div class="mb-0">
                <label class="form-label">Vehicle Type</label>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" value="" id="vtype-all" checked>
                    <label class="form-check-label" for="vtype-all">All Vehicles</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Rides List -->
    <div class="col-12 col-xl-9 reveal" style="animation-delay:.1s">
        <div id="matching-rides-container">
            <div class="card text-center py-5">
                <div class="card-body">
                    <div class="spinner-border mb-3" role="status" style="color:var(--accent);width:36px;height:36px;">
                        <span class="visually-hidden">Searching...</span>
                    </div>
                    <p style="color:var(--text-muted);font-size:15px;margin:0;">Matching routes...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true" style="z-index:1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-modal">
            <div class="modal-header" style="background:linear-gradient(135deg,rgba(108,99,255,0.15),rgba(0,212,170,0.08));border-bottom:1px solid var(--border);">
                <h5 class="modal-title" id="bookModalLabel" style="font-family:'Outfit',sans-serif;font-weight:700;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-shield-check" style="color:var(--teal);"></i> Confirm Ride Booking
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div style="width:52px;height:52px;border-radius:14px;background:var(--accent-soft);color:var(--accent);font-size:22px;display:flex;align-items:center;justify-content:center;margin-right:14px;" id="modal-driver-avatar">🧑</div>
                    <div>
                        <h5 style="font-family:'Outfit',sans-serif;font-weight:700;margin-bottom:3px;" id="modal-driver-name">...</h5>
                        <p style="color:var(--text-muted);font-size:13px;margin:0;" id="modal-vehicle-info">...</p>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label">Fare Breakdown</label>
                    <div class="d-flex justify-content-between mb-2" style="font-size:13.5px;">
                        <span style="color:var(--text-muted);">Fare per seat</span>
                        <span style="font-weight:600;">₹<span id="modal-fare-seat">0.00</span></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" style="font-size:13.5px;">
                        <span style="color:var(--text-muted);">Seats requested</span>
                        <span style="font-weight:600;" id="modal-seats-count">1</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between" style="font-size:16px;font-weight:700;">
                        <span>Total Fare</span>
                        <span style="color:var(--accent);">₹<span id="modal-total-fare">0.00</span></span>
                    </div>
                </div>

                <div class="p-3 rounded-3 mb-4 d-flex align-items-center justify-content-between" style="background:var(--bg-soft);border:1px solid var(--border);">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-wallet2 fs-5" style="color:var(--accent);"></i>
                        <div>
                            <small style="color:var(--text-faint);font-size:10.5px;display:block;text-transform:uppercase;letter-spacing:.06em;">Your Wallet Balance</small>
                            <span style="font-weight:700;color:var(--text);">₹<span id="modal-wallet-balance">0.00</span></span>
                        </div>
                    </div>
                    <span id="modal-wallet-warning" class="badge badge-red d-none">Low Balance</span>
                </div>

                <button type="button" class="btn btn-primary btn-block" id="confirm-booking-btn">
                    <i class="bi bi-wallet2"></i> Instant Pay & Confirm Booking
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?= $baseUrl ?>/assets/js/app.js"></script>
<script src="<?= $baseUrl ?>/assets/js/dashboard.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        loadSearchResults();
    });
</script>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
