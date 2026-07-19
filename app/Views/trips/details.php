<?php
$title = "Trip Tracking";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon" style="background:var(--green-soft);color:var(--green);">
            <i class="bi bi-compass"></i>
        </span>
        Track Commute
    </div>
    <a href="<?= $baseUrl ?>/my-trips" class="btn btn-glass btn-sm">
        <i class="bi bi-arrow-left"></i> My Trips
    </a>
</div>

<div class="row g-4">
    <!-- Map + Info -->
    <div class="col-12 col-xl-7">
        <div class="card overflow-hidden mb-4 reveal" style="animation-delay:.06s">
            <div id="live-map" style="height:400px;z-index:1;"></div>

            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge badge-accent text-uppercase" id="trip-status-badge">
                            <?= str_replace('_', ' ', $booking['status']) ?>
                        </span>
                        <div class="live-dot d-inline-block" style="width:8px;height:8px;border-radius:50%;background:var(--green);"></div>
                    </div>
                    <div class="text-end">
                        <span style="font-size:10.5px;color:var(--text-faint);text-transform:uppercase;letter-spacing:.08em;display:block;">ESTIMATED FARE</span>
                        <h4 class="mono" style="font-weight:700;color:var(--teal);margin:0;">₹<?= number_format($booking['fare_amount'], 2) ?></h4>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <div style="padding:12px;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius-md);">
                            <small style="font-size:10px;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);display:block;margin-bottom:4px;">PICKUP</small>
                            <span style="font-weight:600;color:var(--text);font-size:13px;" id="txt-pickup"><?= htmlspecialchars($booking['pickup_address']) ?></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="padding:12px;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius-md);">
                            <small style="font-size:10px;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);display:block;margin-bottom:4px;">DROP</small>
                            <span style="font-weight:600;color:var(--text);font-size:13px;" id="txt-drop"><?= htmlspecialchars($booking['drop_address']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Driver Control Panel -->
        <?php if ($isDriver): ?>
            <div class="card p-4 mb-4 reveal" style="animation-delay:.1s;background:linear-gradient(145deg,rgba(108,99,255,0.1),rgba(0,212,170,0.05))!important;">
                <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:10px;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-gear-fill" style="color:var(--yellow);"></i> Driver Control Center
                </h5>
                <p style="color:var(--text-muted);font-size:13px;margin-bottom:20px;line-height:1.65;">Start the trip once all passengers are onboard. Ensure location updates are enabled to broadcast your live GPS route.</p>

                <div class="d-flex gap-3">
                    <?php if ($booking['status'] === 'booked'): ?>
                        <button type="button" class="btn btn-teal flex-grow-1" id="btn-start-trip">
                            <i class="bi bi-play-fill"></i> Start Trip
                        </button>
                    <?php elseif (in_array($booking['status'], ['trip_started', 'trip_in_progress'])): ?>
                        <button type="button" class="btn btn-danger flex-grow-1" id="btn-end-trip">
                            <i class="bi bi-stop-fill"></i> Complete Journey
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Payment Panel (Passenger) -->
        <?php if (!$isDriver && $booking['status'] === 'trip_completed'): ?>
            <div class="card p-4 mb-4 reveal" style="animation-delay:.12s;background:var(--accent-soft)!important;border-color:rgba(108,99,255,0.25)!important;">
                <h5 style="font-family:'Outfit',sans-serif;font-weight:700;margin-bottom:8px;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-wallet2" style="color:var(--accent);"></i> Payment Required
                </h5>
                <p style="color:var(--text-muted);font-size:13px;margin-bottom:18px;line-height:1.65;">Your journey is complete! Settle the fare amount with the driver to finalize the ride.</p>
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3" style="border-bottom:1px solid var(--border);">
                    <span style="font-size:15px;color:var(--text);">Amount due:</span>
                    <span class="mono" style="font-size:22px;font-weight:700;color:var(--accent);">₹<?= number_format($booking['fare_amount'], 2) ?></span>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" id="btn-pay-wallet">
                        <i class="bi bi-wallet2"></i> Pay using Wallet
                    </button>
                    <button class="btn btn-glass" id="btn-pay-cash">Settle with Cash</button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right: Participants + Chat -->
    <div class="col-12 col-xl-5">
        <!-- Participants -->
        <div class="card p-4 mb-4 reveal" style="animation-delay:.08s">
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:18px;display:flex;align-items:center;gap:8px;">
                <i class="bi bi-people-fill" style="color:var(--accent);"></i> Participants
            </h5>

            <div class="d-flex align-items-center mb-3 pb-3" style="border-bottom:1px solid var(--border);">
                <div style="width:46px;height:46px;border-radius:13px;background:var(--accent-soft);color:var(--accent);display:flex;align-items:center;justify-content:center;font-size:20px;margin-right:14px;">🧑</div>
                <div class="flex-grow-1">
                    <span class="badge badge-accent mb-1" style="font-size:9.5px;">Driver</span>
                    <h6 style="font-weight:700;margin-bottom:2px;color:var(--text);"><?= htmlspecialchars($booking['driver_name']) ?></h6>
                    <small style="color:var(--text-muted);"><?= htmlspecialchars($booking['driver_phone']) ?></small>
                </div>
                <a href="tel:<?= htmlspecialchars($booking['driver_phone']) ?>" class="btn btn-glass btn-sm" style="width:36px;height:36px;padding:0;display:flex;align-items:center;justify-content:center;border-radius:50%;">
                    <i class="bi bi-telephone-fill" style="color:var(--teal);font-size:13px;"></i>
                </a>
            </div>

            <h6 style="font-weight:600;color:var(--text-muted);font-size:12px;text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px;">Passengers</h6>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($passengers as $p): ?>
                    <div class="d-flex align-items-center">
                        <div style="width:38px;height:38px;border-radius:10px;background:var(--teal-soft);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:17px;margin-right:12px;">👩</div>
                        <div>
                            <span style="font-weight:600;color:var(--text);font-size:13.5px;"><?= htmlspecialchars($p['passenger_name']) ?></span>
                            <small style="color:var(--text-muted);display:block;font-size:11.5px;"><?= htmlspecialchars($p['passenger_phone']) ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Chat Panel -->
        <div class="card overflow-hidden d-flex flex-column reveal" style="height:380px;animation-delay:.11s">
            <div class="card-header d-flex justify-content-between align-items-center py-3 px-4">
                <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:15px;margin:0;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-chat-dots-fill" style="color:var(--accent);"></i> Ride Group Chat
                </h5>
                <span class="badge badge-teal">Active</span>
            </div>

            <div class="card-body p-4 flex-grow-1 overflow-y-auto" id="chat-messages" style="background:var(--bg-soft);">
                <div class="text-center py-5" id="chat-empty" style="color:var(--text-faint);">
                    <i class="bi bi-chat-quote" style="font-size:2.5rem;display:block;margin-bottom:10px;"></i>
                    <p style="font-size:13px;margin:0;">Secure conversation with driver & co-riders.</p>
                </div>
            </div>

            <div class="card-footer p-3" style="border-top:1px solid var(--border);">
                <form id="chat-form">
                    <div class="input-group">
                        <input type="text" class="form-control" id="chat-input" placeholder="Type a message..." required
                               style="border-top-left-radius:var(--radius-pill)!important;border-bottom-left-radius:var(--radius-pill)!important;border-right:none!important;">
                        <button class="btn btn-primary px-4" type="submit"
                                style="border-top-right-radius:var(--radius-pill)!important;border-bottom-right-radius:var(--radius-pill)!important;">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Map tracking variables -->
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
