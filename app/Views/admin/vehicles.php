<?php
$title = "Admin Dashboard - Vehicles";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<!-- Admin Header -->
<div class="d-flex justify-content-between align-items-center mb-4 reveal">
    <div class="d-flex align-items-center gap-3">
        <div style="width:48px;height:48px;border-radius:14px;background:rgba(245,158,11,0.15);color:#F59E0B;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;font-family:'Outfit',sans-serif;">
            <?= strtoupper(substr($stats['org']['name'] ?? 'C', 0, 1)) ?>
        </div>
        <div>
            <h4 style="font-family:'Outfit',sans-serif;font-weight:700;margin:0;"><?= htmlspecialchars($stats['org']['name'] ?? 'Company Name') ?></h4>
            <span style="font-size:11px;color:var(--text-faint);">Fleet Directory</span>
        </div>
    </div>
    <span class="badge badge-red">Admin</span>
</div>

<!-- Admin Stats -->
<div class="row g-3 mb-4 reveal" style="animation-delay:.04s">
    <div class="col-4">
        <div class="stat-card p-3 text-center">
            <div class="stat-label mb-1">Total Employees</div>
            <div class="stat-value mono" style="color:var(--teal);"><?= $stats['total_employees'] ?></div>
        </div>
    </div>
    <div class="col-4">
        <div class="stat-card p-3 text-center">
            <div class="stat-label mb-1">Registered Vehicles</div>
            <div class="stat-value mono" style="color:var(--accent);"><?= $stats['registered_vehicles'] ?></div>
        </div>
    </div>
    <div class="col-4">
        <div class="stat-card p-3 text-center">
            <div class="stat-label mb-1">Rides This Month</div>
            <div class="stat-value mono" style="color:var(--yellow);"><?= $stats['total_rides'] ?></div>
        </div>
    </div>
</div>

<!-- Tabs -->
<div class="d-flex gap-2 mb-4 reveal" style="animation-delay:.06s">
    <a href="<?= $baseUrl ?>/admin/employees" class="btn btn-glass btn-sm"><i class="bi bi-people"></i> Employees</a>
    <a href="<?= $baseUrl ?>/admin/vehicles" class="btn btn-primary btn-sm"><i class="bi bi-car-front"></i> Vehicles</a>
    <a href="<?= $baseUrl ?>/admin/settings" class="btn btn-glass btn-sm"><i class="bi bi-sliders"></i> Settings</a>
</div>

<!-- Fleet Table -->
<div class="card reveal" style="animation-delay:.08s">
    <div class="card-body p-4">
        <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <i class="bi bi-car-front-fill" style="color:var(--teal);"></i> Fleet Registry
        </h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Registration Number</th>
                        <th>Model</th>
                        <th>Seating Capacity</th>
                        <th>Driver</th>
                        <th class="text-end">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($vehicles)): ?>
                        <tr><td colspan="5" class="text-center py-5" style="color:var(--text-muted);">No vehicles found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($vehicles as $v):
                            $isActive = $v['status'] === 'approved';
                        ?>
                        <tr>
                            <td class="mono" style="font-weight:600;color:var(--accent);"><?= htmlspecialchars($v['registration_number']) ?></td>
                            <td style="font-weight:500;"><?= htmlspecialchars($v['model']) ?></td>
                            <td><span class="badge badge-teal"><?= $v['seating_capacity'] ?> seats</span></td>
                            <td><?= htmlspecialchars($v['owner_name'] ?? 'N/A') ?></td>
                            <td class="text-end">
                                <?php if ($isActive): ?>
                                    <span class="badge badge-green">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-red">Inactive</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
