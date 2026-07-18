<?php
$title = "Admin Dashboard - Settings";
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
        <a class="nav-link text-secondary border rounded-0 px-4 py-2" href="<?= $baseUrl ?>/admin/vehicles" style="font-size: 0.9rem;">Vehicles</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active rounded-0 border border-bottom-0 text-dark px-4 py-2" href="<?= $baseUrl ?>/admin/settings" style="font-size: 0.9rem;">Settings</a>
    </li>
</ul>

<!-- Tab Content Area -->
<div class="card border rounded-0 shadow-sm p-4">
    <?php if (!empty($flash)): ?>
        <div class="alert alert-info border-0 rounded-0" role="alert">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>

    <form action="<?= $baseUrl ?>/admin/settings" method="POST">
        <!-- Company Details Section -->
        <h5 class="fw-bold text-info border-bottom pb-2 mb-4" style="font-size: 1.1rem;">Company Details</h5>
        <div class="row g-4 mb-5">
            <div class="col-12 col-md-6">
                <div class="d-flex border-bottom pb-2">
                    <div class="text-muted w-50" style="font-size: 0.85rem;">Company Name</div>
                    <div class="text-dark fw-semibold w-50" style="font-size: 0.9rem;"><?= htmlspecialchars($org['name']) ?></div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="d-flex border-bottom pb-2">
                    <div class="text-muted w-50" style="font-size: 0.85rem;">Industry</div>
                    <div class="text-dark fw-semibold w-50" style="font-size: 0.9rem;">Software</div>
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="d-flex border-bottom pb-2">
                    <div class="text-muted w-50" style="font-size: 0.85rem;">Registered Address</div>
                    <div class="text-dark fw-semibold w-50" style="font-size: 0.9rem;">Gandhinagar</div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="d-flex border-bottom pb-2">
                    <div class="text-muted w-50" style="font-size: 0.85rem;">Admin Contact</div>
                    <div class="text-dark fw-semibold w-50" style="font-size: 0.9rem;">admin@company.com</div>
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="d-flex border-bottom pb-2">
                    <div class="text-muted w-50" style="font-size: 0.85rem;">Registered Employees</div>
                    <div class="text-dark fw-semibold w-50" style="font-size: 0.9rem;"><?= $stats['total_employees'] ?></div>
                </div>
            </div>
        </div>

        <!-- Carpooling Configuration Section -->
        <h5 class="fw-bold text-info border-bottom pb-2 mb-4" style="font-size: 1.1rem;">Carpooling Configuration</h5>
        <div class="row g-4 mb-5 align-items-center">
            <div class="col-12 col-md-6">
                <div class="d-flex align-items-center border-bottom pb-2">
                    <div class="text-muted w-50" style="font-size: 0.85rem;">Fuel Cost / Liter</div>
                    <div class="w-50">
                        <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-semibold p-0 text-dark" value="Rs. 96.50">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="d-flex align-items-center border-bottom pb-2">
                    <div class="text-muted w-50" style="font-size: 0.85rem;">Cost Per KM (Database)</div>
                    <div class="w-50">
                        <input type="number" class="form-control form-control-sm border-0 bg-transparent fw-semibold p-0 text-dark" name="default_fare_per_km" step="0.5" value="<?= number_format($org['default_fare_per_km'], 2) ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="d-flex align-items-center border-bottom pb-2">
                    <div class="text-muted w-50" style="font-size: 0.85rem;">Travel Cost (Operational)</div>
                    <div class="w-50">
                        <input type="number" class="form-control form-control-sm border-0 bg-transparent fw-semibold p-0 text-dark" name="fuel_cost_per_km" step="0.5" value="<?= number_format($org['fuel_cost_per_km'], 2) ?>" required>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-outline-info rounded-0 text-info fw-semibold px-4 py-2" style="font-size: 0.9rem;">Save Settings</button>
        </div>
    </form>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
