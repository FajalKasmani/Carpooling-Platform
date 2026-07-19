<?php
$title = "Confirm Commute Route";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon" style="background:var(--teal-soft);color:var(--teal);">
            <i class="bi bi-map-fill"></i>
        </span>
        Confirm Commute Route
    </div>
    <a href="<?= $baseUrl ?>/dashboard" class="btn btn-glass btn-sm">
        <i class="bi bi-arrow-left"></i> Modify Options
    </a>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-5 reveal" style="animation-delay:.06s">
        <div class="card p-4">
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
                <i class="bi bi-info-circle" style="color:var(--accent);"></i> Trip Summary
            </h5>

            <div class="d-flex flex-column gap-3 mb-4">
                <div style="padding:14px;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius-md);">
                    <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);margin-bottom:5px;">PICKUP</div>
                    <span style="font-weight:600;color:var(--text);" id="txt-pickup">Ahmedabad</span>
                </div>
                <div style="padding:14px;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius-md);">
                    <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);margin-bottom:5px;">DROP</div>
                    <span style="font-weight:600;color:var(--text);" id="txt-drop">Gandhinagar</span>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div style="padding:14px;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius-md);">
                            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);margin-bottom:5px;">DISTANCE</div>
                            <span class="mono" style="font-size:18px;font-weight:700;color:var(--accent);">24.5 km</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="padding:14px;background:var(--bg-soft);border:1px solid var(--border);border-radius:var(--radius-md);">
                            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-faint);margin-bottom:5px;">FUEL EST.</div>
                            <span class="mono" style="font-size:18px;font-weight:700;color:var(--teal);">1.6 L</span>
                        </div>
                    </div>
                </div>
            </div>

            <a href="<?= $baseUrl ?>/find-ride" class="btn btn-primary btn-block">
                <i class="bi bi-check-circle"></i> Confirm Route
            </a>
        </div>
    </div>

    <div class="col-12 col-lg-7 reveal" style="animation-delay:.1s">
        <div class="card p-3 h-100">
            <div id="live-map" style="height:100%;min-height:400px;border-radius:var(--radius-md);overflow:hidden;z-index:1;"></div>
        </div>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
