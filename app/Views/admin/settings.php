<?php
$title = "Org settings";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold text-gradient" style="background: linear-gradient(135deg, #f59e0b, #d97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><i class="bi bi-sliders me-2"></i>Organization Config</h1>
    <a href="<?= $baseUrl ?>/admin/dashboard" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-2"></i>Admin Dashboard</a>
</div>

<div class="row">
    <div class="col-12 col-md-6 mx-auto">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-calculator-fill text-primary me-2"></i>Carpool Rate Metrics</h5>
            
            <?php if (!empty($flash)): ?>
                <div class="alert alert-danger border-0 text-white bg-danger bg-opacity-25" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($flash['message']) ?>
                </div>
            <?php endif; ?>
            
            <form action="<?= $baseUrl ?>/admin/settings" method="POST">
                <div class="mb-4">
                    <label for="fuel_cost_per_km" class="form-label fw-semibold text-muted">Estimated Fuel Cost (per km)</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-transparent border-secondary text-muted">₹</span>
                        <input type="number" class="form-control" id="fuel_cost_per_km" name="fuel_cost_per_km" min="0" step="0.5" value="<?= number_format($org['fuel_cost_per_km'], 2) ?>" required>
                    </div>
                    <div class="form-text text-muted" style="font-size: 0.75rem;">Used to compute estimated eco CO₂ fuel savings reports.</div>
                </div>
                
                <div class="mb-4">
                    <label for="default_fare_per_km" class="form-label fw-semibold text-muted">Default Seat Fare (per km)</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-transparent border-secondary text-muted">₹</span>
                        <input type="number" class="form-control" id="default_fare_per_km" name="default_fare_per_km" min="0" step="0.5" value="<?= number_format($org['default_fare_per_km'], 2) ?>" required>
                    </div>
                    <div class="form-text text-muted" style="font-size: 0.75rem;">Baseline suggested fare per seat recommended on Offer Ride forms.</div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-3 shadow-sm py-2.5">
                    <i class="bi bi-check-circle me-2"></i>Save Configuration
                </button>
            </form>
        </div>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
