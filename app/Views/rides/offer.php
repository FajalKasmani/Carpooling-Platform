<?php
$title = "Offer a Ride";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon">
            <i class="bi bi-plus-circle"></i>
        </span>
        Offer a Ride
    </div>
</div>

<?php if (empty($vehicles)): ?>
    <!-- No Vehicles State -->
    <div class="card reveal" style="animation-delay:.06s">
        <div class="card-body p-5 text-center">
            <div style="width:64px;height:64px;border-radius:18px;background:var(--accent-soft);color:var(--accent);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:28px;">
                <i class="bi bi-car-front"></i>
            </div>
            <h4 style="font-family:'Outfit',sans-serif;font-weight:700;margin-bottom:10px;">No Vehicle Registered</h4>
            <p style="color:var(--text-muted);max-width:460px;margin:0 auto 24px;font-size:14px;line-height:1.65;">
                You need to register at least one approved vehicle before you can publish a ride. Add your vehicle details now to start sharing routes.
            </p>
            <a href="<?= $baseUrl ?>/vehicles/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Register a Vehicle
            </a>
        </div>
    </div>
<?php else: ?>

<div class="row g-4">
    <!-- Form -->
    <div class="col-12 col-xl-5 reveal" style="animation-delay:.06s">
        <div class="card p-4">
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:20px;display:flex;align-items:center;gap:9px;">
                <span style="width:28px;height:28px;border-radius:8px;background:var(--teal-soft);color:var(--teal);display:inline-flex;align-items:center;justify-content:center;font-size:13px;">
                    <i class="bi bi-signpost-split-fill"></i>
                </span>
                Publish Commute Route
            </h5>

            <form id="offer-ride-form" autocomplete="off">
                <!-- Vehicle -->
                <div class="mb-3">
                    <label class="form-label">Select Vehicle</label>
                    <select class="form-select" id="vehicle_id" required>
                        <option value="" disabled selected>Choose your vehicle</option>
                        <?php foreach ($vehicles as $v): ?>
                            <option value="<?= $v['id'] ?>" data-capacity="<?= $v['seating_capacity'] ?>">
                                <?= htmlspecialchars($v['model']) ?> (<?= htmlspecialchars($v['registration_number']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

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
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" id="travel_date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Time</label>
                        <input type="time" class="form-control" id="travel_time" value="08:30" required>
                    </div>
                </div>

                <!-- Seats & Fare -->
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label">Available Seats</label>
                        <select class="form-select" id="available_seats">
                            <option value="1">1 Seat</option>
                            <option value="2">2 Seats</option>
                            <option value="3" selected>3 Seats</option>
                            <option value="4">4 Seats</option>
                        </select>
                        <div class="form-text" style="color:var(--text-faint);font-size:11px;margin-top:6px;">Driver seat excluded.</div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Fare per seat (₹)</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" id="fare_per_seat" min="0" value="80" required>
                        </div>
                        <div class="form-text" style="color:var(--text-faint);font-size:11px;margin-top:6px;" id="suggested-fare-tip">Fare.</div>
                    </div>
                </div>

                <input type="hidden" id="distance_km">
                <input type="hidden" id="route_polyline">

                <!-- Recurring -->
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_recurring" value="1">
                        <label class="form-check-label" for="is_recurring">Repeat daily (Monday to Friday)</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-teal btn-block" id="publish-btn" disabled>
                    <i class="bi bi-check-circle"></i> Publish Shared Route
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
        initOfferMap();
    });
</script>

<?php endif; ?>
<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
