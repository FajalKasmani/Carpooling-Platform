<?php
$title = "Reports & Analytics";
require_once dirname(__DIR__) . '/layouts/header.php';
//require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Reports & Analytics</h1>
    <a href="<?= $baseUrl ?>/ride-history" class="btn btn-outline-secondary btn-sm"><i class="bi bi-clock-history me-2"></i>Ride History</a>
</div>

<!-- Aggregated Summary Cards -->
<div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-compass fs-3"></i>
            </div>
            <h6 class="text-muted fw-bold text-uppercase" style="font-size: 0.8rem;">Commute Distance</h6>
            <h2 class="fw-bold mb-1" id="rep-distance">0 km</h2>
            <p class="text-muted mb-0" style="font-size: 0.85rem;">Total distance shared with colleagues</p>
        </div>
    </div>
    
    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
            <div class="bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-tree fs-3"></i>
            </div>
            <h6 class="text-muted fw-bold text-uppercase" style="font-size: 0.8rem;">CO₂ Emission Saved</h6>
            <h2 class="fw-bold text-success mb-1" id="rep-co2">0 kg</h2>
            <p class="text-muted mb-0" style="font-size: 0.85rem;">Reduced carbon footprint metrics</p>
        </div>
    </div>
    
    <div class="col">
        <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center">
            <div class="bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-droplet fs-3"></i>
            </div>
            <h6 class="text-muted fw-bold text-uppercase" style="font-size: 0.8rem;">Fuel Saved</h6>
            <h2 class="fw-bold mb-1" id="rep-fuel">0 Litres</h2>
            <p class="text-muted mb-0" style="font-size: 0.85rem;">Estimated fuel consumption avoided</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Chart Box -->
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-graph-up text-primary me-2"></i>Commuting Activity Trend</h5>
            <div style="position: relative; height: 320px;">
                <canvas id="commuteChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Cost savings sidebar widgets inside Reports -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 bg-dark text-white shadow-sm rounded-4 p-4 h-100 d-flex flex-column justify-content-between">
            <div>
                <h5 class="fw-bold mb-3"><i class="bi bi-shield-check text-warning me-2"></i>Financial Benefits</h5>
                <p class="text-muted mb-4" style="font-size: 0.9rem;">By sharing your route or booking seats with team colleagues, you have optimized your overall travel expenses.</p>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Total Spent (Passenger)</span>
                    <h5 class="fw-bold mb-0">₹<span id="rep-spent">0.00</span></h5>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Total Earned (Driver)</span>
                    <h5 class="fw-bold text-gradient mb-0" style="background: linear-gradient(135deg, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">₹<span id="rep-earned">0.00</span></h5>
                </div>
            </div>
            
            <div class="border-top border-secondary pt-3 mt-3">
                <small class="text-muted d-block mb-1">AVERAGE COST SAVED PER KM</small>
                <span class="fs-6 fw-semibold text-info">₹<?= isset($_SESSION['org_id']) ? '8.00' : '8.00' ?> / km default setting</span>
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
            
            // Build trend chart
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
                            backgroundColor: 'rgba(14, 165, 233, 0.65)',
                            borderColor: '#0ea5e9',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Distance (KM)',
                            data: distances.length ? distances : [0],
                            type: 'line',
                            borderColor: '#818cf8',
                            backgroundColor: 'transparent',
                            borderWidth: 3,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: { display: true, text: 'Rides' }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            title: { display: true, text: 'Distance (KM)' }
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
