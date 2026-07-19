<?php
$title = "Offer a Ride";
require_once dirname(__DIR__) . '/layouts/header.php';
//require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-plus-circle me-2 text-primary"></i>Offer a Ride</h1>
</div>

<?php if (empty($vehicles)): ?>
    <!-- No Vehicles Prompt -->
    <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
        <i class="bi bi-car-front fs-1 text-muted mb-3"></i>
        <h4 class="fw-bold">No Vehicle Registered</h4>
        <p class="text-muted max-width-500 mx-auto mb-4">You need to register at least one approved vehicle before you can publish a ride. Add your vehicle details now to start sharing routes.</p>
        <a href="<?= $baseUrl ?>/vehicles/create" class="btn btn-primary fw-bold px-4 py-2.5 rounded-3 shadow-sm">
            <i class="bi bi-plus-circle me-2"></i>Register a Vehicle
        </a>
    </div>
<?php else: ?>

<div class="row g-4">
    <!-- Publish Ride Form -->
    <div class="col-12 col-xl-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-signpost-split-fill me-2 text-primary"></i>Publish Commute Route</h5>
            
            <form id="offer-ride-form" autocomplete="off">
                <div class="mb-3 position-relative">
                    <label class="form-label fw-semibold text-muted">Select Vehicle</label>
                    <select class="form-select" id="vehicle_id" required>
                        <option value="" disabled selected>Choose your vehicle</option>
                        <?php foreach ($vehicles as $v): ?>
                            <option value="<?= $v['id'] ?>" data-capacity="<?= $v['seating_capacity'] ?>">
                                <?= htmlspecialchars($v['model']) ?> (<?= htmlspecialchars($v['registration_number']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3 position-relative">
                    <label class="form-label fw-semibold text-muted">Pickup Location</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent text-primary border-secondary"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" class="form-control" id="pickup_address" placeholder="Enter starting neighborhood" required>
                    </div>
                    <input type="hidden" id="pickup_lat">
                    <input type="hidden" id="pickup_lng">
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
                    <div class="list-group position-absolute w-100 shadow-sm z-3 d-none mt-1" id="drop-suggestions" style="max-height: 200px; overflow-y: auto;"></div>
                </div>
                
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-muted">Date</label>
                        <input type="date" class="form-control" id="travel_date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-muted">Time</label>
                        <input type="time" class="form-control" id="travel_time" value="08:30" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <label class="form-label fw-semibold text-muted">Available Seats</label>
                        <select class="form-select" id="available_seats">
                            <option value="1">1 Seat</option>
                            <option value="2">2 Seats</option>
                            <option value="3" selected>3 Seats</option>
                            <option value="4">4 Seats</option>
                        </select>
                        <div class="form-text text-muted" style="font-size: 0.75rem;">Driver seat is excluded.</div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold text-muted">Fare per seat (₹)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-secondary">₹</span>
                            <input type="number" class="form-control" id="fare_per_seat" min="0" value="80" required>
                        </div>
                        <div class="form-text text-muted" style="font-size: 0.75rem;" id="suggested-fare-tip">Fare.</div>
                    </div>
                </div>

                <input type="hidden" id="distance_km">
                <input type="hidden" id="route_polyline">

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_recurring" value="1">
                        <label class="form-check-label fw-semibold text-muted" for="is_recurring">Repeat daily (Monday to Friday)</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-3 shadow-sm py-2.5" id="publish-btn" disabled>
                    <i class="bi bi-check-circle me-2"></i>Publish Shared Route
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
        initOfferMap();
    });
</script>

<?php endif; ?>
<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
