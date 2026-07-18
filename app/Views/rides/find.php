<?php
$title = "Find a Ride";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-search me-2 text-primary"></i>Find a Ride</h1>
</div>

<div class="row g-4">
    <!-- Search Form Side -->
    <div class="col-12 col-xl-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-geo-alt-fill me-2 text-primary"></i>Commute Route Details</h5>
            
            <form id="search-ride-form" autocomplete="off">
                <div class="mb-3 position-relative">
                    <label class="form-label fw-semibold text-muted">Pickup Location</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent text-primary border-secondary"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" class="form-control" id="pickup_address" placeholder="Enter starting neighborhood" required>
                    </div>
                    <input type="hidden" id="pickup_lat">
                    <input type="hidden" id="pickup_lng">
                    <!-- Suggestions Dropdown -->
                    <div class="list-group position-absolute w-100 shadow-sm z-3 d-none mt-1" id="pickup-suggestions" style="max-height: 200px; overflow-y: auto;"></div>
                </div>
                
                <div class="mb-3 position-relative">
                    <label class="form-label fw-semibold text-muted">Destination Location</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent text-danger border-secondary"><i class="bi bi-geo-fill"></i></span>
                        <input type="text" class="form-control" id="drop_address" placeholder="Enter office campus or area" required>
                    </div>
                    <input type="hidden" id="drop_lat">
                    <input type="hidden" id="drop_lng">
                    <!-- Suggestions Dropdown -->
                    <div class="list-group position-absolute w-100 shadow-sm z-3 d-none mt-1" id="drop-suggestions" style="max-height: 200px; overflow-y: auto;"></div>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-muted">Departure Date</label>
                        <input type="date" class="form-control" id="travel_date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-muted">Preferred Time</label>
                        <input type="time" class="form-control" id="travel_time" value="09:00" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Seats Needed</label>
                    <select class="form-select" id="seats">
                        <option value="1" selected>1 Seat</option>
                        <option value="2">2 Seats</option>
                        <option value="3">3 Seats</option>
                        <option value="4">4 Seats</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-3 shadow-sm py-2.5">
                    <i class="bi bi-search me-2"></i>Search Available Rides
                </button>
            </form>
        </div>
    </div>
    
    <!-- Map Side -->
    <div class="col-12 col-xl-7">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div id="live-map" style="height: 100%; min-height: 480px; border-radius: 12px; overflow: hidden; z-index: 1;"></div>
        </div>
    </div>
</div>

<script src="<?= $baseUrl ?>/assets/js/map.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        initSearchMap();
    });
</script>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
