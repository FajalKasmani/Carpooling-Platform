<?php
$title = "Available Rides";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-card-list me-2 text-primary"></i>Available Rides</h1>
    <a href="<?= $baseUrl ?>/find-ride" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-2"></i>Modify Search</a>
</div>

<!-- Search Summary Header -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-primary bg-opacity-10 text-primary-dark">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center flex-wrap gap-3">
            <div><i class="bi bi-geo-alt-fill fs-4 text-primary"></i></div>
            <div>
                <span class="fw-bold" id="header-pickup">...</span>
                <i class="bi bi-arrow-right mx-2 text-muted"></i>
                <span class="fw-bold" id="header-drop">...</span>
            </div>
        </div>
        <div class="d-flex gap-3">
            <span class="badge bg-light text-primary border border-primary-subtle py-2 px-3 fs-6 rounded-pill" id="header-date">...</span>
            <span class="badge bg-light text-primary border border-primary-subtle py-2 px-3 fs-6 rounded-pill" id="header-seats">1 Seat</span>
        </div>
    </div>
</div>

<div class="row">
    <!-- Filter sidebar -->
    <div class="col-12 col-xl-3 mb-4 mb-xl-0">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-funnel me-2"></i>Filter Matches</h5>
            
            <div class="mb-4">
                <label class="form-label fw-semibold text-muted">Sort By</label>
                <select class="form-select" id="sort-filter">
                    <option value="time">Departure Time</option>
                    <option value="fare">Lowest Fare</option>
                    <option value="rating">Driver Rating</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-semibold text-muted">Max Fare: ₹<span id="fare-range-val">500</span></label>
                <input type="range" class="form-range" id="fare-range" min="10" max="500" step="10" value="500">
            </div>

            <div class="mb-0">
                <label class="form-label fw-semibold text-muted">Vehicle Type</label>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" value="" id="vtype-all" checked>
                    <label class="form-check-label" for="vtype-all">All Vehicles</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Matchings list -->
    <div class="col-12 col-xl-9">
        <div id="matching-rides-container">
            <!-- Dynamic listing via search JS -->
            <div class="text-center text-muted py-5 card border-0 shadow-sm rounded-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Searching...</span>
                </div>
                <p class="mb-0 fs-5">Matching routes...</p>
            </div>
        </div>
    </div>
</div>

<!-- Booking Confirmation Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-modal">
            <div class="modal-header border-0 bg-primary text-white py-3">
                <h5 class="modal-title fw-bold" id="bookModalLabel"><i class="bi bi-shield-check me-2"></i>Confirm Ride Booking</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="fs-1 text-primary me-3 bg-primary bg-opacity-10 p-3 rounded-circle" id="modal-driver-avatar">🧑</div>
                    <div>
                        <h5 class="fw-bold mb-1" id="modal-driver-name">...</h5>
                        <p class="text-muted mb-0" id="modal-vehicle-info">...</p>
                    </div>
                </div>
                
                <hr class="border-secondary mb-4 opacity-10">
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Fare Breakdown</label>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Fare per seat</span>
                        <span class="fw-semibold">₹<span id="modal-fare-seat">0.00</span></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Seats requested</span>
                        <span class="fw-semibold" id="modal-seats-count">1</span>
                    </div>
                    <hr class="border-secondary opacity-10 my-2">
                    <div class="d-flex justify-content-between fs-5 fw-bold text-dark">
                        <span>Total Fare</span>
                        <span>₹<span id="modal-total-fare">0.00</span></span>
                    </div>
                </div>
                
                <div class="bg-light p-3 rounded-3 mb-4 border d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-wallet2 text-primary fs-4 me-2"></i>
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Your Wallet Balance</small>
                            <span class="fw-bold">₹<span id="modal-wallet-balance">0.00</span></span>
                        </div>
                    </div>
                    <span id="modal-wallet-warning" class="badge bg-danger rounded-pill d-none">Low Balance</span>
                </div>
                
                <button type="button" class="btn btn-primary btn-lg w-100 fw-bold rounded-3 py-2.5 shadow-sm" id="confirm-booking-btn">
                    <i class="bi bi-wallet2 me-2"></i>Instant Pay & Confirm Booking
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?= $baseUrl ?>/assets/js/app.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        loadSearchResults();
    });
</script>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
