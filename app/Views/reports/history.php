<?php
$title = "Ride History";
require_once dirname(__DIR__) . '/layouts/header.php';
//require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Ride History</h1>
    <a href="<?= $baseUrl ?>/reports" class="btn btn-outline-secondary btn-sm"><i class="bi bi-bar-chart-line me-2"></i>Analytics Overview</a>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-receipt text-primary me-2"></i>Completed Commutes</h5>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle border-0">
            <thead class="table-light">
                <tr>
                    <th class="border-0 rounded-start">Date & Time</th>
                    <th class="border-0">Role</th>
                    <th class="border-0">Pickup & Destination</th>
                    <th class="border-0">Driver/Vehicle</th>
                    <th class="border-0 text-end rounded-end">Fare</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($history)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-calendar-x fs-2 mb-2 d-block text-secondary opacity-50"></i>
                            No completed rides found.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($history as $h): ?>
                        <tr>
                            <td>
                                <span class="fw-semibold text-dark"><?= date('M d, Y', strtotime($h['travel_date'])) ?></span>
                                <small class="text-muted d-block"><?= date('h:i A', strtotime($h['travel_time'])) ?></small>
                            </td>
                            <td>
                                <span class="badge rounded-pill text-uppercase px-2.5 py-1.5 fw-bold bg-<?= $h['user_role'] === 'driver' ? 'info' : 'primary' ?> bg-opacity-10 text-<?= $h['user_role'] === 'driver' ? 'info' : 'primary' ?>" style="font-size: 0.65rem;">
                                    <?= $h['user_role'] ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1.5 mb-1">
                                    <i class="bi bi-geo-alt-fill text-primary" style="font-size: 0.85rem;"></i>
                                    <small class="text-dark fw-medium text-truncate" style="max-width: 250px;"><?= htmlspecialchars($h['pickup_address']) ?></small>
                                </div>
                                <div class="d-flex align-items-center gap-1.5">
                                    <i class="bi bi-geo-fill text-danger" style="font-size: 0.85rem;"></i>
                                    <small class="text-muted text-truncate" style="max-width: 250px;"><?= htmlspecialchars($h['drop_address']) ?></small>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark"><?= htmlspecialchars($h['driver_name']) ?></span>
                                <small class="text-muted d-block"><?= htmlspecialchars($h['vehicle_model']) ?></small>
                            </td>
                            <td class="text-end fw-bold text-dark">
                                ₹<?= number_format($h['fare_amount'], 2) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
