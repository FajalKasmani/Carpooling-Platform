<?php
$title = "Trip Tracking";
require_once dirname(__DIR__) . '/layouts/header.php';
//require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-compass me-2 text-primary"></i>Track Commute</h1>
    <a href="<?= $baseUrl ?>/my-trips" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-2"></i>My Trips</a>
</div>

<div class="row g-4">
    <!-- Route & Tracker Info -->
    <div class="col-12 col-xl-7">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div id="live-map" style="height: 400px; z-index: 1;"></div>
            
            <div class="card-body p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="badge rounded-pill text-uppercase px-3 py-1.5 fw-bold bg-primary bg-opacity-10 text-primary border border-primary-subtle" id="trip-status-badge">
                            <?= str_replace('_', ' ', $booking['status']) ?>
                        </span>
                        <div class="live-dot d-inline-block ms-2 bg-success rounded-circle" style="width: 8px; height: 8px;"></div>
                    </div>
                    <div class="text-end">
                        <span class="text-muted d-block" style="font-size: 0.75rem;">ESTIMATED FARE</span>
                        <h4 class="fw-bold text-dark mb-0">₹<?= number_format($booking['fare_amount'], 2) ?></h4>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <small class="text-muted d-block">PICKUP</small>
                        <span class="fw-semibold text-dark" id="txt-pickup"><?= htmlspecialchars($booking['pickup_address']) ?></span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">DROP</small>
                        <span class="fw-semibold text-dark" id="txt-drop"><?= htmlspecialchars($booking['drop_address']) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Driver Control Panel -->
        <?php if ($isDriver): ?>
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-dark text-white">
                <h5 class="fw-bold mb-3"><i class="bi bi-gear-fill me-2 text-warning"></i>Driver Control Center</h5>
                <p class="text-muted" style="font-size: 0.9rem;">Start the trip once all passengers are onboard. Ensure location updates are enabled to broadcast your live GPS route.</p>
                
                <div class="d-flex gap-3">
                    <?php if ($booking['status'] === 'booked'): ?>
                        <button type="button" class="btn btn-primary btn-lg flex-grow-1 fw-bold rounded-3" id="btn-start-trip">
                            <i class="bi bi-play-fill me-2"></i>Start Trip
                        </button>
                    <?php elseif (in_array($booking['status'], ['trip_started', 'trip_in_progress'])): ?>
                        <button type="button" class="btn btn-danger btn-lg flex-grow-1 fw-bold rounded-3" id="btn-end-trip">
                            <i class="bi bi-stop-fill me-2"></i>Complete Journey
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Payment Trigger Panel (Passenger complete view) -->
        <?php if (!$isDriver && $booking['status'] === 'trip_completed'): ?>
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-light border border-primary-subtle text-dark">
                <h5 class="fw-bold mb-2"><i class="bi bi-wallet2 me-2 text-primary"></i>Payment Required</h5>
                <p class="text-muted" style="font-size: 0.9rem;">Your journey is complete! Settle the fare amount with the driver to finalize the ride.</p>
                <div class="d-flex align-items-center justify-content-between mb-3 border-top pt-3 mt-2">
                    <span class="fs-5">Amount due:</span>
                    <span class="fs-4 fw-bold">₹<?= number_format($booking['fare_amount'], 2) ?></span>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg fw-bold rounded-3" id="btn-pay-wallet">
                        <i class="bi bi-wallet2 me-2"></i>Pay using Wallet
                    </button>
                    <button class="btn btn-outline-secondary rounded-3" id="btn-pay-cash">
                        Settle with Cash
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right Column: Participant Details & Chat Box -->
    <div class="col-12 col-xl-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-people-fill me-2 text-primary"></i>Participants</h5>
            
            <div class="d-flex align-items-center mb-3">
                <div class="fs-2 bg-light border rounded-circle d-flex align-items-center justify-content-center text-dark me-3" style="width: 50px; height: 50px;">🧑</div>
                <div class="flex-grow-1">
                    <span class="badge bg-secondary mb-1">Driver</span>
                    <h6 class="fw-bold text-dark mb-0"><?= htmlspecialchars($booking['driver_name']) ?></h6>
                    <small class="text-muted"><?= htmlspecialchars($booking['driver_phone']) ?></small>
                </div>
                <a href="tel:<?= htmlspecialchars($booking['driver_phone']) ?>" class="btn btn-light rounded-circle"><i class="bi bi-telephone-fill text-success"></i></a>
            </div>
            
            <hr class="border-secondary opacity-10 my-3">
            
            <h6 class="fw-semibold text-muted mb-2.5">Passengers</h6>
            <div class="d-flex flex-column gap-2">
                <?php foreach ($passengers as $p): ?>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="fs-5 bg-light border rounded-circle d-flex align-items-center justify-content-center text-dark me-2.5" style="width: 38px; height: 38px;">👩</div>
                            <div>
                                <span class="fw-semibold text-dark"><?= htmlspecialchars($p['passenger_name']) ?></span>
                                <small class="text-muted d-block"><?= htmlspecialchars($p['passenger_phone']) ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Chat Panel -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column" style="height: 380px;">
            <div class="card-header bg-transparent border-0 pt-3 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-chat-dots-fill me-2 text-primary"></i>Ride Group Chat</h5>
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1">Active</span>
            </div>
            
            <!-- Chat logs -->
            <div class="card-body p-4 flex-grow-1 overflow-y-auto" id="chat-messages" style="background-color: #f8fafc;">
                <div class="text-center text-muted py-5" id="chat-empty">
                    <i class="bi bi-chat-quote fs-1 mb-2 text-secondary opacity-50"></i>
                    <p class="mb-0" style="font-size: 0.85rem;">Secure conversation with driver & co-riders.</p>
                </div>
            </div>
            
            <!-- Chat input -->
            <div class="card-footer bg-white border-top p-3">
                <form id="chat-form">
                    <div class="input-group">
                        <input type="text" class="form-control rounded-start-pill py-2.5 border-end-0" id="chat-input" placeholder="Type a message..." required>
                        <button class="btn btn-primary rounded-end-pill px-4" type="submit">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Map tracking logic variables -->
<script>
    const bookingId = <?= $booking['id'] ?>;
    const isDriver = <?= $isDriver ? 'true' : 'false' ?>;
    const pickupLat = <?= $booking['pickup_lat'] ?? 'null' ?>;
    const pickupLng = <?= $booking['pickup_lng'] ?? 'null' ?>;
    const dropLat = <?= $booking['drop_lat'] ?? 'null' ?>;
    const dropLng = <?= $booking['drop_lng'] ?? 'null' ?>;
    const routePolyline = '<?= $booking['route_polyline'] ?? '' ?>';
</script>
<script src="<?= $baseUrl ?>/assets/js/map.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        initTrackingMap();
    });
</script>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
