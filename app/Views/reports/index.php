<?php
$title = "Reports & Analytics";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon" style="background:var(--yellow-soft);color:var(--yellow);">
            <i class="bi bi-bar-chart-line"></i>
        </span>
        Reports & Analytics
    </div>
    <a href="<?= $baseUrl ?>/ride-history" class="btn btn-glass btn-sm">
        <i class="bi bi-clock-history"></i> Ride History
    </a>
</div>

<!-- Summary Cards -->
<div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
    <div class="col reveal" style="animation-delay:.06s">
        <div class="stat-card p-4 text-center">
            <div class="stat-icon orange mx-auto mb-3" style="width:52px;height:52px;border-radius:14px;font-size:22px;">
                <i class="bi bi-compass"></i>
            </div>
            <div class="stat-label mb-2">Commute Distance</div>
            <div class="stat-value mono mb-1" id="rep-distance">0 km</div>
            <p style="color:var(--text-faint);font-size:12px;margin:0;">Total distance shared with colleagues</p>
        </div>
    </div>

    <div class="col reveal" style="animation-delay:.09s">
        <div class="stat-card p-4 text-center">
            <div class="stat-icon teal mx-auto mb-3" style="width:52px;height:52px;border-radius:14px;font-size:22px;">
                <i class="bi bi-tree"></i>
            </div>
            <div class="stat-label mb-2">CO₂ Emission Saved</div>
            <div class="stat-value mono mb-1" id="rep-co2" style="color:var(--teal);">0 kg</div>
            <p style="color:var(--text-faint);font-size:12px;margin:0;">Reduced carbon footprint metrics</p>
        </div>
    </div>

    <div class="col reveal" style="animation-delay:.12s">
        <div class="stat-card p-4 text-center">
            <div class="stat-icon yellow mx-auto mb-3" style="width:52px;height:52px;border-radius:14px;font-size:22px;">
                <i class="bi bi-droplet"></i>
            </div>
            <div class="stat-label mb-2">Fuel Saved</div>
            <div class="stat-value mono mb-1" id="rep-fuel">0 Litres</div>
            <p style="color:var(--text-faint);font-size:12px;margin:0;">Estimated fuel consumption avoided</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Chart -->
    <div class="col-12 col-lg-8 reveal" style="animation-delay:.15s">
        <div class="card p-4 h-100">
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
                <i class="bi bi-graph-up" style="color:var(--accent);"></i> Commuting Activity Trend
            </h5>
            <div style="position:relative;height:320px;">
                <canvas id="commuteChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Financial Benefits -->
    <div class="col-12 col-lg-4 reveal" style="animation-delay:.18s">
        <div class="card p-4 h-100 d-flex flex-column justify-content-between" style="background:linear-gradient(145deg,rgba(108,99,255,0.08),rgba(0,212,170,0.04))!important;">
            <div>
                <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:10px;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-shield-check" style="color:var(--yellow);"></i> Financial Benefits
                </h5>
                <p style="color:var(--text-muted);font-size:13px;margin-bottom:24px;line-height:1.65;">
                    By sharing your route or booking seats with team colleagues, you have optimized your overall travel expenses.
                </p>

                <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom:1px solid var(--border);">
                    <span style="color:var(--text-muted);font-size:13px;">Total Spent (Passenger)</span>
                    <h5 class="mono mb-0" style="color:var(--text);">₹<span id="rep-spent">0.00</span></h5>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span style="color:var(--text-muted);font-size:13px;">Total Earned (Driver)</span>
                    <h5 class="mono mb-0 text-gradient">₹<span id="rep-earned">0.00</span></h5>
                </div>
            </div>

            <div style="border-top:1px solid var(--border);padding-top:14px;margin-top:8px;">
                <small style="color:var(--text-faint);font-size:10px;text-transform:uppercase;letter-spacing:.1em;display:block;margin-bottom:4px;">AVG COST SAVED PER KM</small>
                <span class="mono" style="font-size:15px;font-weight:600;color:var(--teal);">₹<?= isset($_SESSION['org_id']) ? '8.00' : '8.00' ?> / km default setting</span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const res = await fetchJSON('/reports/summary');
        if (res.success) {
            document.getElementById('rep-distance').innerText = res.summary.total_distance_km + ' km';
            document.getElementById('rep-co2').innerText = res.summary.co2_saved_kg + ' kg';
            document.getElementById('rep-fuel').innerText = res.summary.fuel_saved_litres + ' L';
            document.getElementById('rep-spent').innerText = res.summary.total_spent.toFixed(2);
            document.getElementById('rep-earned').innerText = res.summary.total_earned.toFixed(2);

            const months = res.monthly.map(m => m.month);
            const trips = res.monthly.map(m => m.trips);
            const distances = res.monthly.map(m => m.distance);

            const ctx = document.getElementById('commuteChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months.length ? months : ['No Data'],
                    datasets: [
                        {
                            label: 'Rides Shared',
                            data: trips.length ? trips : [0],
                            backgroundColor: 'rgba(108,99,255,0.5)',
                            borderColor: '#6C63FF',
                            borderWidth: 1,
                            borderRadius: 6,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Distance (KM)',
                            data: distances.length ? distances : [0],
                            type: 'line',
                            borderColor: '#00D4AA',
                            backgroundColor: 'rgba(0,212,170,0.08)',
                            borderWidth: 2.5,
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'y1'
                        }
                    ]
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
                            type: 'linear', display: true, position: 'left',
                            ticks: { color: '#64748B' },
                            grid: { color: 'rgba(15, 23, 42, 0.05)' },
                            title: { display: true, text: 'Rides', color: '#64748B' }
                        },
                        y1: {
                            type: 'linear', display: true, position: 'right',
                            ticks: { color: '#64748B' },
                            grid: { drawOnChartArea: false },
                            title: { display: true, text: 'Distance (KM)', color: '#64748B' }
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
