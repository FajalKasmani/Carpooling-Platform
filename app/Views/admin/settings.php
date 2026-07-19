<?php
$title = "Admin Dashboard - Settings";
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
            <span style="font-size:11px;color:var(--text-faint);">System Configuration</span>
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
    <a href="<?= $baseUrl ?>/admin/vehicles" class="btn btn-glass btn-sm"><i class="bi bi-car-front"></i> Vehicles</a>
    <a href="<?= $baseUrl ?>/admin/settings" class="btn btn-primary btn-sm"><i class="bi bi-sliders"></i> Settings</a>
</div>

<!-- Settings Form Card -->
<div class="card reveal" style="animation-delay:.08s">
    <div class="card-body p-4">
        <?php if (!empty($flash)): 
            $msg = is_string($flash) ? $flash : ($flash['message'] ?? $flash['success'] ?? $flash['error'] ?? 'Settings updated');
        ?>
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-circle me-2"></i><?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <form action="<?= $baseUrl ?>/admin/settings" method="POST">
            <!-- Company Details Section -->
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:20px;padding-bottom:10px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;">
                <i class="bi bi-building" style="color:var(--accent);"></i> Company Details
            </h5>
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6">
                    <div style="padding:14px;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius-md);display:flex;justify-content:between;">
                        <span style="font-size:13px;color:var(--text-muted);width:50%;">Company Name</span>
                        <span style="font-size:13px;font-weight:600;color:var(--text);width:50%;text-align:right;"><?= htmlspecialchars($org['name']) ?></span>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div style="padding:14px;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius-md);display:flex;justify-content:between;">
                        <span style="font-size:13px;color:var(--text-muted);width:50%;">Industry</span>
                        <span style="font-size:13px;font-weight:600;color:var(--text);width:50%;text-align:right;">Software</span>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div style="padding:14px;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius-md);display:flex;justify-content:between;">
                        <span style="font-size:13px;color:var(--text-muted);width:50%;">Registered Address</span>
                        <span style="font-size:13px;font-weight:600;color:var(--text);width:50%;text-align:right;">Gandhinagar</span>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div style="padding:14px;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius-md);display:flex;justify-content:between;">
                        <span style="font-size:13px;color:var(--text-muted);width:50%;">Admin Contact</span>
                        <span style="font-size:13px;font-weight:600;color:var(--text);width:50%;text-align:right;">admin@company.com</span>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div style="padding:14px;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius-md);display:flex;justify-content:between;">
                        <span style="font-size:13px;color:var(--text-muted);width:50%;">Registered Employees</span>
                        <span style="font-size:13px;font-weight:600;color:var(--text);width:50%;text-align:right;"><?= $stats['total_employees'] ?></span>
                    </div>
                </div>
            </div>

            <!-- Carpooling Configuration Section -->
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:20px;padding-bottom:10px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;margin-top:40px;">
                <i class="bi bi-sliders" style="color:var(--teal);"></i> Carpooling Configuration
            </h5>
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Fuel Cost / Liter</label>
                        <input type="text" class="form-control" value="Rs. 96.50" disabled style="opacity:0.6;">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Cost Per KM (Database)</label>
                        <input type="number" class="form-control mono" name="default_fare_per_km" step="0.5" value="<?= number_format($org['default_fare_per_km'], 2) ?>" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Travel Cost (Operational)</label>
                        <input type="number" class="form-control mono" name="fuel_cost_per_km" step="0.5" value="<?= number_format($org['fuel_cost_per_km'], 2) ?>" required>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Save Settings
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
