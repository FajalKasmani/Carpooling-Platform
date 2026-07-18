<?php
$title = "Admin Dashboard - Vehicles";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<!-- Unified Admin Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 48px; height: 48px; font-size: 1.2rem;">
            <?= strtoupper(substr($stats['org']['name'] ?? 'C', 0, 1)) ?>
        </div>
        <h4 class="mb-0 fw-bold text-dark"><?= htmlspecialchars($stats['org']['name'] ?? 'Company Name') ?></h4>
    </div>
    <div>
        <span class="badge bg-danger rounded-pill px-3 py-2 fs-6">Admin</span>
    </div>
</div>

<!-- Unified Stats Panel -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="card border border-secondary-subtle shadow-sm rounded-0 h-100">
            <div class="card-body py-2 px-3">
                <div class="text-dark fw-semibold" style="font-size: 0.85rem;">Total Employees</div>
                <div class="fs-4 text-info fw-bold"><?= $stats['total_employees'] ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border border-secondary-subtle shadow-sm rounded-0 h-100">
            <div class="card-body py-2 px-3">
                <div class="text-dark fw-semibold" style="font-size: 0.85rem;">Registered Vehicles</div>
                <div class="fs-4 text-info fw-bold"><?= $stats['registered_vehicles'] ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border border-secondary-subtle shadow-sm rounded-0 h-100">
            <div class="card-body py-2 px-3">
                <div class="text-dark fw-semibold" style="font-size: 0.85rem;">Rides This Month</div>
                <div class="fs-4 text-info fw-bold"><?= $stats['total_rides'] ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Unified Tabs -->
<ul class="nav nav-tabs mb-0 border-bottom-0 gap-1" style="font-family: inherit;">
    <li class="nav-item">
        <a class="nav-link text-secondary border rounded-0 px-4 py-2" href="<?= $baseUrl ?>/admin/employees" style="font-size: 0.9rem;">Employees</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active rounded-0 border border-bottom-0 text-dark px-4 py-2" href="<?= $baseUrl ?>/admin/vehicles" style="font-size: 0.9rem;">Vehicles</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-secondary border rounded-0 px-4 py-2" href="<?= $baseUrl ?>/admin/settings" style="font-size: 0.9rem;">Settings</a>
    </li>
</ul>

<!-- Tab Content Area -->
<div class="card border rounded-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-borderless table-striped align-middle mb-0" style="font-size: 0.85rem;">
                <thead>
                    <tr class="border-bottom text-info">
                        <th class="fw-normal py-3 ps-4">Registration Number</th>
                        <th class="fw-normal py-3">Model</th>
                        <th class="fw-normal py-3">Seating Capacity</th>
                        <th class="fw-normal py-3">Driver</th>
                        <th class="fw-normal py-3 pe-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($vehicles)): ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted">No vehicles found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($vehicles as $v): 
                            $isActive = $v['status'] === 'approved';
                        ?>
                        <tr class="border-bottom">
                            <td class="ps-4 text-dark"><?= htmlspecialchars($v['registration_number']) ?></td>
                            <td class="text-dark"><?= htmlspecialchars($v['model']) ?></td>
                            <td class="text-dark"><?= $v['seating_capacity'] ?></td>
                            <td class="text-dark"><?= htmlspecialchars($v['owner_name'] ?? 'N/A') ?></td>
                            <td class="pe-4">
                                <?php if ($isActive): ?>
                                    <span class="text-success" style="font-size: 0.85rem;">[Active]</span>
                                <?php else: ?>
                                    <span class="text-danger" style="font-size: 0.85rem;">[Inactive]</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-top">
            <button class="btn btn-outline-info rounded-0 text-info fw-semibold px-4 py-1" style="font-size: 0.85rem;">+ Add Vehicle</button>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
