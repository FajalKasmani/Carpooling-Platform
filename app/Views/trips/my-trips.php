<?php
$title = "My Trips";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon" style="background:var(--orange-soft);color:var(--orange);">
            <i class="bi bi-calendar-event"></i>
        </span>
        My Trips
    </div>
</div>

<!-- Custom Tabs -->
<div class="mb-4 reveal" style="animation-delay:.04s">
    <div style="display:flex;gap:4px;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius-md);padding:4px;width:fit-content;">
        <button class="nav-link active" id="passenger-tab" data-bs-toggle="tab" data-bs-target="#passenger" type="button" role="tab"
                style="padding:8px 18px;border-radius:8px;font-size:13px;font-weight:600;border:none;background:var(--accent);color:#fff;display:flex;align-items:center;gap:7px;">
            <i class="bi bi-person"></i> Booked as Passenger
        </button>
        <button class="nav-link" id="driver-tab" data-bs-toggle="tab" data-bs-target="#driver" type="button" role="tab"
                style="padding:8px 18px;border-radius:8px;font-size:13px;font-weight:600;border:none;background:transparent;color:var(--text-muted);display:flex;align-items:center;gap:7px;transition:all .15s;">
            <i class="bi bi-car-front"></i> Offered as Driver
        </button>
    </div>
</div>

<div class="tab-content" id="tripsTabContent">
    <!-- Passenger Tab -->
    <div class="tab-pane fade show active" id="passenger" role="tabpanel" aria-labelledby="passenger-tab">
        <?php if (empty($activeTrips)): ?>
            <div class="card reveal" style="animation-delay:.06s">
                <div class="card-body p-5 text-center">
                    <div style="width:64px;height:64px;border-radius:18px;background:var(--orange-soft);color:var(--orange);display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 16px;">
                        <i class="bi bi-calendar-x"></i>
                    </div>
                    <h5 style="font-family:'Outfit',sans-serif;font-weight:700;margin-bottom:8px;">No Active Bookings</h5>
                    <p style="color:var(--text-muted);font-size:13.5px;">You have not booked any rides yet.</p>
                    <a href="<?= $baseUrl ?>/find-ride" class="btn btn-primary mt-3">
                        <i class="bi bi-search"></i> Find a Ride
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-lg-2 g-4">
                <?php foreach ($activeTrips as $t): ?>
                    <div class="col reveal" style="animation-delay:.06s">
                        <div class="ride-card h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge badge-accent">
                                        <?= date('M d, Y', strtotime($t['travel_date'])) ?> — <?= date('h:i A', strtotime($t['travel_time'])) ?>
                                    </span>
                                    <span class="badge badge-green text-uppercase">
                                        <?= str_replace('_', ' ', $t['status']) ?>
                                    </span>
                                </div>

                                <div class="d-flex flex-column gap-3 mb-3">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bi bi-geo-alt-fill mt-1" style="color:var(--accent);"></i>
                                        <div>
                                            <small style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);display:block;">PICKUP</small>
                                            <span style="font-weight:600;color:var(--text);"><?= htmlspecialchars($t['pickup_address']) ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bi bi-geo-fill mt-1" style="color:var(--teal);"></i>
                                        <div>
                                            <small style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);display:block;">DROP</small>
                                            <span style="font-weight:600;color:var(--text);"><?= htmlspecialchars($t['drop_address']) ?></span>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:36px;height:36px;border-radius:10px;background:var(--accent-soft);color:var(--accent);display:flex;align-items:center;justify-content:center;font-size:16px;">🧑</div>
                                        <div>
                                            <small style="font-size:10px;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);display:block;">DRIVER</small>
                                            <span style="font-weight:700;color:var(--text);"><?= htmlspecialchars($t['driver_name']) ?></span>
                                        </div>
                                    </div>
                                    <a href="<?= $baseUrl ?>/trip/<?= $t['id'] ?>" class="btn btn-primary btn-sm">
                                        <i class="bi bi-compass"></i> Track & Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Driver Tab -->
    <div class="tab-pane fade" id="driver" role="tabpanel" aria-labelledby="driver-tab">
        <?php if (empty($offeredRides)): ?>
            <div class="card">
                <div class="card-body p-5 text-center">
                    <div style="width:64px;height:64px;border-radius:18px;background:var(--teal-soft);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 16px;">
                        <i class="bi bi-car-front"></i>
                    </div>
                    <h5 style="font-family:'Outfit',sans-serif;font-weight:700;margin-bottom:8px;">No Offered Rides</h5>
                    <p style="color:var(--text-muted);font-size:13.5px;">You have not published any rides yet.</p>
                    <a href="<?= $baseUrl ?>/offer-ride" class="btn btn-teal mt-3">
                        <i class="bi bi-plus-circle"></i> Offer a Ride
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-lg-2 g-4">
                <?php foreach ($offeredRides as $r): ?>
                    <div class="col">
                        <div class="ride-card h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge badge-accent">
                                        <?= date('M d, Y', strtotime($r['travel_date'])) ?> — <?= date('h:i A', strtotime($r['travel_time'])) ?>
                                    </span>
                                    <span class="badge badge-teal text-uppercase">
                                        <?= str_replace('_', ' ', $r['status']) ?>
                                    </span>
                                </div>

                                <div class="d-flex flex-column gap-3 mb-3">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bi bi-geo-alt-fill mt-1" style="color:var(--accent);"></i>
                                        <div>
                                            <small style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);display:block;">PICKUP</small>
                                            <span style="font-weight:600;color:var(--text);"><?= htmlspecialchars($r['pickup_address']) ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bi bi-geo-fill mt-1" style="color:var(--teal);"></i>
                                        <div>
                                            <small style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);display:block;">DROP</small>
                                            <span style="font-weight:600;color:var(--text);"><?= htmlspecialchars($r['drop_address']) ?></span>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small style="font-size:10px;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);display:block;">VEHICLE</small>
                                        <span style="font-weight:700;color:var(--text);"><?= htmlspecialchars($r['vehicle_model']) ?></span>
                                    </div>
                                    <div class="text-end">
                                        <small style="font-size:10px;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);display:block;">BOOKED SEATS</small>
                                        <span class="badge badge-accent px-3"><?= $r['booked_seats'] ?> / <?= $r['total_seats'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Make driver tab button visually toggle
document.querySelectorAll('[data-bs-toggle="tab"]').forEach(btn => {
    btn.addEventListener('shown.bs.tab', function() {
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(b => {
            b.style.background = 'transparent';
            b.style.color = 'var(--text-muted)';
        });
        this.style.background = 'var(--accent)';
        this.style.color = '#fff';
    });
});
</script>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
