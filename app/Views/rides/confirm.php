<?php
$title = "Confirm Commute Route";
require_once dirname(__DIR__) . '/layouts/header.php';
//require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-map-fill me-2 text-primary"></i>Confirm Commute Route</h1>
    <a href="<?= $baseUrl ?>/dashboard" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-2"></i>Modify Options</a>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-info-circle text-primary me-2"></i>Trip Summary</h5>
            
            <div class="d-flex flex-column gap-3 mb-4">
                <div>
                    <small class="text-muted d-block" style="font-size: 0.75rem;">PICKUP</small>
                    <span class="fw-semibold text-dark" id="txt-pickup">Ahmedabad</span>
                </div>
                <div>
                    <small class="text-muted d-block" style="font-size: 0.75rem;">DROP</small>
                    <span class="fw-semibold text-dark" id="txt-drop">Gandhinagar</span>
                </div>
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted d-block" style="font-size: 0.75rem;">ESTIMATED DISTANCE</small>
                        <span class="fw-bold text-dark fs-5">24.5 km</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block" style="font-size: 0.75rem;">FUEL ESTIMATION</small>
                        <span class="fw-bold text-success fs-5">1.6 Litres</span>
                    </div>
                </div>
            </div>
            
            <a href="<?= $baseUrl ?>/find-ride" class="btn btn-primary btn-lg w-100 fw-bold rounded-3 shadow-sm py-2.5">
                <i class="bi bi-check-circle me-2"></i>Confirm Route
            </a>
        </div>
    </div>
    
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
            <div id="live-map" style="height: 100%; min-height: 400px; border-radius: 12px; overflow: hidden; z-index: 1;"></div>
        </div>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
