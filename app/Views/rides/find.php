<?php
$title = "Find a Ride";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon">
            <i class="bi bi-search"></i>
        </span>
        Find a Ride
    </div>
</div>

<div class="row g-4">
    <!-- Search Form -->
    <div class="col-12 col-xl-5 reveal" style="animation-delay:.06s">
        <div class="card p-4">
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:20px;display:flex;align-items:center;gap:9px;">
                <span style="width:28px;height:28px;border-radius:8px;background:var(--accent-soft);color:var(--accent);display:inline-flex;align-items:center;justify-content:center;font-size:13px;">
                    <i class="bi bi-geo-alt-fill"></i>
                </span>
                Commute Route Details
            </h5>

            <form id="search-ride-form" autocomplete="off">
                <!-- Pickup -->
                <div class="mb-3 position-relative">
                    <label class="form-label">Pickup Location</label>
                    <div class="input-group">
                        <span class="input-group-text" style="color:var(--accent);"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" class="form-control" id="pickup_address" placeholder="Enter starting neighborhood" required>
                    </div>
                    <input type="hidden" id="pickup_lat">
                    <input type="hidden" id="pickup_lng">
                    <div class="list-group position-absolute w-100 z-3 d-none mt-1" id="pickup-suggestions" style="max-height:200px;overflow-y:auto;border-radius:var(--radius-md);"></div>
                </div>

                <!-- Destination -->
                <div class="mb-3 position-relative">
                    <label class="form-label">Destination Location</label>
                    <div class="input-group">
                        <span class="input-group-text" style="color:var(--teal);"><i class="bi bi-geo-fill"></i></span>
                        <input type="text" class="form-control" id="drop_address" placeholder="Enter office campus or area" required>
                    </div>
                    <input type="hidden" id="drop_lat">
                    <input type="hidden" id="drop_lng">
                    <div class="list-group position-absolute w-100 z-3 d-none mt-1" id="drop-suggestions" style="max-height:200px;overflow-y:auto;border-radius:var(--radius-md);"></div>
                </div>

                <!-- Date & Time -->
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label">Departure Date</label>
                        <input type="date" class="form-control" id="travel_date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Preferred Time</label>
                        <input type="time" class="form-control" id="travel_time" value="09:00" required>
                    </div>
                </div>

                <!-- Seats -->
                <div class="mb-4">
                    <label class="form-label">Seats Needed</label>
                    <select class="form-select" id="seats">
                        <option value="1" selected>1 Seat</option>
                        <option value="2">2 Seats</option>
                        <option value="3">3 Seats</option>
                        <option value="4">4 Seats</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="bi bi-search"></i> Search Available Rides
                </button>
            </form>
        </div>
    </div>

    <!-- Map -->
    <div class="col-12 col-xl-7 reveal" style="animation-delay:.1s">
        <div class="card p-3 h-100">
            <div id="live-map" style="height:100%;min-height:480px;border-radius:var(--radius-md);overflow:hidden;z-index:1;"></div>
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
