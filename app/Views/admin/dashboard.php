<?php
$title = "Admin Dashboard";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon" style="background:rgba(245,158,11,0.12);color:#F59E0B;">
            <i class="bi bi-shield-lock-fill"></i>
        </span>
        <span class="text-gradient">Admin Dashboard</span>
    </div>
    <span class="badge" style="background:rgba(245,158,11,0.12);color:#F59E0B;border:1px solid rgba(245,158,11,0.25);font-size:12px;font-weight:600;padding:7px 14px;border-radius:100px;">
        <?= htmlspecialchars($stats['org']['name'] ?? 'Organization') ?>
    </span>
</div>

<!-- Stats -->
<div class="row row-cols-1 row-cols-sm-3 g-4 mb-4">
    <div class="col reveal" style="animation-delay:.06s">
        <div class="stat-card p-4 text-center">
            <div class="stat-icon accent mx-auto mb-3" style="width:52px;height:52px;border-radius:14px;font-size:22px;">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-label mb-1">Active Employees</div>
            <div class="stat-value mono mb-2"><?= $stats['total_employees'] ?></div>
            <a href="<?= $baseUrl ?>/admin/employees" style="font-size:12.5px;font-weight:600;color:var(--accent);">Manage Directory →</a>
        </div>
    </div>

    <div class="col reveal" style="animation-delay:.09s">
        <div class="stat-card p-4 text-center">
            <div class="stat-icon teal mx-auto mb-3" style="width:52px;height:52px;border-radius:14px;font-size:22px;">
                <i class="bi bi-car-front"></i>
            </div>
            <div class="stat-label mb-1">Vehicles Registered</div>
            <div class="stat-value mono mb-2" id="admin-dash-vehicles">0</div>
            <a href="<?= $baseUrl ?>/admin/vehicles" style="font-size:12.5px;font-weight:600;color:var(--teal);">Moderate Fleet →</a>
        </div>
    </div>

    <div class="col reveal" style="animation-delay:.12s">
        <div class="stat-card p-4 text-center">
            <div class="stat-icon yellow mx-auto mb-3" style="width:52px;height:52px;border-radius:14px;font-size:22px;">
                <i class="bi bi-signpost-split"></i>
            </div>
            <div class="stat-label mb-1">Shared Commutes</div>
            <div class="stat-value mono mb-1"><?= $stats['total_rides'] ?> <small style="font-size:13px;">offered</small></div>
            <span style="color:var(--text-muted);font-size:12.5px;"><?= $stats['total_bookings'] ?> bookings total</span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Chart -->
    <div class="col-12 col-lg-8 reveal" style="animation-delay:.15s">
        <div class="card p-4 h-100">
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                <i class="bi bi-bar-chart-fill" style="color:#F59E0B;"></i> Eco & Financial Savings
            </h5>
            <div class="row text-center mb-4 g-0" style="border:1px solid var(--border);border-radius:var(--radius-md);overflow:hidden;">
                <div class="col-6 col-md-3 p-3" style="border-right:1px solid var(--border);">
                    <span style="font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--text-faint);display:block;margin-bottom:5px;">CO₂ REDUCED</span>
                    <h4 class="mono mb-0" style="color:var(--teal);" id="stat-co2">0 kg</h4>
                </div>
                <div class="col-6 col-md-3 p-3" style="border-right:1px solid var(--border);">
                    <span style="font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--text-faint);display:block;margin-bottom:5px;">TOTAL KM RUN</span>
                    <h4 class="mono mb-0" id="stat-distance">0 km</h4>
                </div>
                <div class="col-6 col-md-3 p-3" style="border-right:1px solid var(--border);">
                    <span style="font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--text-faint);display:block;margin-bottom:5px;">EST. COSTS SAVED</span>
                    <h4 class="mono mb-0" style="color:var(--accent);" id="stat-cost">₹0</h4>
                </div>
                <div class="col-6 col-md-3 p-3">
                    <span style="font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--text-faint);display:block;margin-bottom:5px;">PARTICIPATION RATE</span>
                    <h4 class="mono mb-0" style="color:#F59E0B;" id="stat-participation">0%</h4>
                </div>
            </div>
            <div style="position:relative;height:260px;">
                <canvas id="adminOrgChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Oversight Options -->
    <div class="col-12 col-lg-4 reveal" style="animation-delay:.18s">
        <div class="card p-4 h-100 d-flex flex-column justify-content-between" style="background:linear-gradient(145deg,rgba(245,158,11,0.07),rgba(108,99,255,0.05))!important;">
            <div>
                <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:10px;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-gear-wide-connected" style="color:#F59E0B;"></i> Oversight Options
                </h5>
                <p style="color:var(--text-muted);font-size:13px;margin-bottom:24px;line-height:1.65;">Modify the company mileage rules, default fare per km settings, or add/remove employee directory rights.</p>

                <div class="d-grid gap-2">
                    <a href="<?= $baseUrl ?>/admin/settings" class="btn btn-glass d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-sliders me-2" style="color:#F59E0B;"></i>Organization Config</span>
                        <i class="bi bi-chevron-right" style="font-size:11px;color:var(--text-faint);"></i>
                    </a>
                    <a href="<?= $baseUrl ?>/admin/employees" class="btn btn-glass d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-shield-check me-2" style="color:var(--teal);"></i>Employee Statuses</span>
                        <i class="bi bi-chevron-right" style="font-size:11px;color:var(--text-faint);"></i>
                    </a>
                </div>
            </div>

            <div style="border-top:1px solid var(--border);padding-top:14px;margin-top:14px;">
                <small style="font-size:10px;text-transform:uppercase;letter-spacing:.1em;color:var(--text-faint);display:block;margin-bottom:4px;">MILEAGE FORMULA DEFAULT</small>
                <span class="mono" style="font-size:15px;font-weight:600;color:var(--teal);">₹<?= number_format($stats['org']['default_fare_per_km'], 2) ?> per shared km</span>
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
                        backgroundColor: 'rgba(245,158,11,0.6)',
                        borderColor: '#F59E0B',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { labels: { color: '#475569', font: { family: 'Inter', size: 12 } } }
                    },
                    scales: {
                        x: { ticks: { color: '#64748B' }, grid: { color: 'rgba(15, 23, 42, 0.05)' } },
                        y: {
                            ticks: { stepSize: 1, color: '#64748B' },
                            grid: { color: 'rgba(15, 23, 42, 0.05)' }
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
