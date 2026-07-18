<?php
$title = "Admin Dashboard";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold text-gradient" style="background: linear-gradient(135deg, #f59e0b, #d97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><i class="bi bi-shield-lock-fill me-2"></i>Admin Dashboard</h1>
    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold border border-warning-subtle"><?= htmlspecialchars($stats['org']['name'] ?? 'Organization') ?></span>
</div>

<!-- Admin Dashboard Overview Cards -->
<div class="row row-cols-1 row-cols-sm-3 g-4 mb-4">
    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-people fs-3"></i>
            </div>
            <h6 class="text-muted fw-bold text-uppercase" style="font-size: 0.8rem;">Active Employees</h6>
            <h2 class="fw-bold mb-1"><?= $stats['total_employees'] ?></h2>
            <a href="<?= $baseUrl ?>/admin/employees" class="text-decoration-none fw-semibold" style="font-size: 0.85rem;">Manage Directory</a>
        </div>
    </div>
    
    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
            <div class="bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-car-front fs-3"></i>
            </div>
            <h6 class="text-muted fw-bold text-uppercase" style="font-size: 0.8rem;">Vehicles Registered</h6>
            <h2 class="fw-bold mb-1" id="admin-dash-vehicles">0</h2>
            <a href="<?= $baseUrl ?>/admin/vehicles" class="text-decoration-none fw-semibold text-success" style="font-size: 0.85rem;">Moderate Fleet</a>
        </div>
    </div>
    
    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
            <div class="bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-signpost-split fs-3"></i>
            </div>
            <h6 class="text-muted fw-bold text-uppercase" style="font-size: 0.8rem;">Shared Commutes</h6>
            <h2 class="fw-bold mb-1"><?= $stats['total_rides'] ?> Offered</h2>
            <span class="text-muted" style="font-size: 0.85rem;"><?= $stats['total_bookings'] ?> Bookings</span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Admin Org metrics chart -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Eco & Financial Savings</h5>
            <div class="row text-center mb-4">
                <div class="col-6 col-md-3 border-end">
                    <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">CO₂ REDUCED</span>
                    <h4 class="fw-bold text-success" id="stat-co2">0 kg</h4>
                </div>
                <div class="col-6 col-md-3 border-end">
                    <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">TOTAL KM RUN</span>
                    <h4 class="fw-bold text-dark" id="stat-distance">0 km</h4>
                </div>
                <div class="col-6 col-md-3 border-end">
                    <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">EST. COSTS SAVED</span>
                    <h4 class="fw-bold text-info" id="stat-cost">₹0</h4>
                </div>
                <div class="col-6 col-md-3">
                    <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">PARTICIPATION RATE</span>
                    <h4 class="fw-bold text-warning" id="stat-participation">0%</h4>
                </div>
            </div>
            <div style="position: relative; height: 260px;">
                <canvas id="adminOrgChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Admin Settings Shortcuts Panel -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 bg-dark text-white shadow-sm rounded-4 p-4 h-100 d-flex flex-column justify-content-between">
            <div>
                <h5 class="fw-bold mb-3"><i class="bi bi-gear-wide-connected text-warning me-2"></i>Oversight Options</h5>
                <p class="text-muted mb-4" style="font-size: 0.9rem;">Modify the company mileage rules, default fare per km settings, or add/remove employee directory rights.</p>
                
                <div class="d-grid gap-2">
                    <a href="<?= $baseUrl ?>/admin/settings" class="btn btn-outline-light d-flex align-items-center justify-content-between py-2 px-3 rounded-3">
                        <span><i class="bi bi-sliders me-2 text-warning"></i>Organization Config</span>
                        <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
                    </a>
                    <a href="<?= $baseUrl ?>/admin/employees" class="btn btn-outline-light d-flex align-items-center justify-content-between py-2 px-3 rounded-3">
                        <span><i class="bi bi-shield-check me-2 text-info"></i>Employee Statuses</span>
                        <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem;"></i>
                    </a>
                </div>
            </div>
            
            <div class="border-top border-secondary pt-3 mt-3">
                <small class="text-muted d-block mb-1">MILEAGE FORMULA DEFAULT</small>
                <span class="fs-6 fw-semibold text-info">₹<?= number_format($stats['org']['default_fare_per_km'], 2) ?> per shared km</span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const res = await fetchJSON('/reports/admin');
        if (res.success) {
            document.getElementById('admin-dash-vehicles').innerText = res.vehicle_stats.length;
            document.getElementById('stat-co2').innerText = res.summary.co2_saved_kg + ' kg';
            document.getElementById('stat-distance').innerText = res.summary.total_distance_km + ' km';
            document.getElementById('stat-cost').innerText = '₹' + res.summary.cost_saved;
            document.getElementById('stat-participation').innerText = res.summary.participation_rate + '%';
            
            // Build simple top vehicles chart
            const labels = res.vehicle_stats.map(v => v.model + ' (' + v.registration_number + ')');
            const data = res.vehicle_stats.map(v => v.rides_count);
            
            const ctx = document.getElementById('adminOrgChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels.slice(0, 5),
                    datasets: [{
                        label: 'Rides Offered by Vehicle',
                        data: data.slice(0, 5),
                        backgroundColor: '#d97706',
                        borderColor: '#b45309',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }
    });
</script>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
