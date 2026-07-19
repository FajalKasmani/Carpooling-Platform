<?php
$title = "Ride History";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon" style="background:var(--orange-soft);color:var(--orange);">
            <i class="bi bi-clock-history"></i>
        </span>
        Ride History
    </div>
    <a href="<?= $baseUrl ?>/reports" class="btn btn-glass btn-sm">
        <i class="bi bi-bar-chart-line"></i> Analytics Overview
    </a>
</div>

<div class="card reveal" style="animation-delay:.06s">
    <div class="card-body p-4">
        <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <i class="bi bi-receipt" style="color:var(--accent);"></i> Completed Commutes
        </h5>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Role</th>
                        <th>Pickup & Destination</th>
                        <th>Driver/Vehicle</th>
                        <th class="text-end">Fare</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($history)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div style="width:48px;height:48px;border-radius:14px;background:var(--bg-soft);display:flex;align-items:center;justify-content:center;font-size:22px;color:var(--text-faint);margin:0 auto 14px;">
                                    <i class="bi bi-calendar-x"></i>
                                </div>
                                <div style="color:var(--text-muted);font-size:13.5px;">No completed rides found.</div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($history as $h): ?>
                            <tr>
                                <td>
                                    <span style="font-weight:600;"><?= date('M d, Y', strtotime($h['travel_date'])) ?></span>
                                    <small style="color:var(--text-muted);display:block;"><?= date('h:i A', strtotime($h['travel_time'])) ?></small>
                                </td>
                                <td>
                                    <span class="badge <?= $h['user_role'] === 'driver' ? 'badge-teal' : 'badge-accent' ?> text-uppercase">
                                        <?= $h['user_role'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="bi bi-geo-alt-fill" style="color:var(--accent);font-size:12px;"></i>
                                        <small style="color:var(--text);max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($h['pickup_address']) ?></small>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-geo-fill" style="color:var(--teal);font-size:12px;"></i>
                                        <small style="color:var(--text-muted);max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($h['drop_address']) ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-weight:600;"><?= htmlspecialchars($h['driver_name']) ?></span>
                                    <small style="color:var(--text-muted);display:block;"><?= htmlspecialchars($h['vehicle_model']) ?></small>
                                </td>
                                <td class="text-end mono" style="font-weight:700;color:var(--teal);">
                                    ₹<?= number_format($h['fare_amount'], 2) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
