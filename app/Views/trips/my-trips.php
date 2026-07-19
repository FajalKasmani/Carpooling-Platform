<?php
$title = "My Trips";
require_once dirname(__DIR__) . '/layouts/header.php';
//require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-calendar-event me-2 text-primary"></i>My Trips</h1>
</div>

<ul class="nav nav-tabs border-bottom mb-4" id="tripsTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active fw-semibold" id="passenger-tab" data-bs-toggle="tab" data-bs-target="#passenger" type="button" role="tab" aria-controls="passenger" aria-selected="true">
            <i class="bi bi-person me-2"></i>Booked as Passenger
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link fw-semibold" id="driver-tab" data-bs-toggle="tab" data-bs-target="#driver" type="button" role="tab" aria-controls="driver" aria-selected="false">
            <i class="bi bi-car-front me-2"></i>Offered as Driver
        </button>
    </li>
</ul>

<div class="tab-content" id="tripsTabContent">
    <!-- Passenger Tab -->
    <div class="tab-pane fade show active" id="passenger" role="tabpanel" aria-labelledby="passenger-tab">
        <?php if (empty($activeTrips)): ?>
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                <i class="bi bi-calendar-x fs-1 text-muted mb-3"></i>
                <h5 class="fw-bold">No Active Bookings</h5>
                <p class="text-muted">You have not booked any rides yet.</p>
                <a href="<?= $baseUrl ?>/find-ride" class="btn btn-primary fw-bold px-4 py-2.5 rounded-3 shadow-sm mt-3">
                    <i class="bi bi-search me-2"></i>Find a Ride
                </a>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-lg-2 g-4">
                <?php foreach ($activeTrips as $t): ?>
                    <div class="col">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden ride-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fw-semibold">
                                        <?= date('M d, Y', strtotime($t['travel_date'])) ?> — <?= date('h:i A', strtotime($t['travel_time'])) ?>
                                    </span>
                                    <span class="badge rounded-pill text-uppercase px-2.5 py-1.5 fw-bold bg-success bg-opacity-10 text-success border border-success-subtle">
                                        <?= str_replace('_', ' ', $t['status']) ?>
                                    </span>
                                </div>
                                
                                <div class="d-flex flex-column gap-2 mb-3">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bi bi-geo-alt-fill text-primary mt-1"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">PICKUP</small>
                                            <span class="fw-semibold text-dark"><?= htmlspecialchars($t['pickup_address']) ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bi bi-geo-fill text-danger mt-1"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">DROP</small>
                                            <span class="fw-semibold text-dark"><?= htmlspecialchars($t['drop_address']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="border-secondary opacity-10">
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center text-dark fs-5 me-2" style="width: 40px; height: 40px;">🧑</div>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">DRIVER</small>
                                            <span class="fw-bold text-dark"><?= htmlspecialchars($t['driver_name']) ?></span>
                                        </div>
                                    </div>
                                    
                                    <a href="<?= $baseUrl ?>/trip/<?= $t['id'] ?>" class="btn btn-primary fw-semibold rounded-3 py-2 px-3 shadow-sm">
                                        <i class="bi bi-compass me-2"></i>Track & Details
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
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                <i class="bi bi-car-front fs-1 text-muted mb-3"></i>
                <h5 class="fw-bold">No Offered Rides</h5>
                <p class="text-muted">You have not published any rides yet.</p>
                <a href="<?= $baseUrl ?>/offer-ride" class="btn btn-primary fw-bold px-4 py-2.5 rounded-3 shadow-sm mt-3">
                    <i class="bi bi-plus-circle me-2"></i>Offer a Ride
                </a>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-lg-2 g-4">
                <?php foreach ($offeredRides as $r): ?>
                    <div class="col">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden ride-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fw-semibold">
                                        <?= date('M d, Y', strtotime($r['travel_date'])) ?> — <?= date('h:i A', strtotime($r['travel_time'])) ?>
                                    </span>
                                    <span class="badge rounded-pill text-uppercase px-2.5 py-1.5 fw-bold bg-info bg-opacity-10 text-info border border-info-subtle">
                                        <?= str_replace('_', ' ', $r['status']) ?>
                                    </span>
                                </div>
                                
                                <div class="d-flex flex-column gap-2 mb-3">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bi bi-geo-alt-fill text-primary mt-1"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">PICKUP</small>
                                            <span class="fw-semibold text-dark"><?= htmlspecialchars($r['pickup_address']) ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="bi bi-geo-fill text-danger mt-1"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">DROP</small>
                                            <span class="fw-semibold text-dark"><?= htmlspecialchars($r['drop_address']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="border-secondary opacity-10">
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">VEHICLE</small>
                                        <span class="fw-bold text-dark"><?= htmlspecialchars($r['vehicle_model']) ?></span>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">BOOKED SEATS</small>
                                        <span class="badge bg-dark rounded-pill fw-semibold px-3 py-1.5"><?= $r['booked_seats'] ?> / <?= $r['total_seats'] ?></span>
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

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
