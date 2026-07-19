<?php
$title = "My Vehicles";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon" style="background:var(--teal-soft);color:var(--teal);">
            <i class="bi bi-car-front"></i>
        </span>
        My Vehicles
    </div>
    <a href="<?= $baseUrl ?>/vehicles/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Vehicle
    </a>
</div>

<?php if (empty($vehicles)): ?>
    <div class="card reveal" style="animation-delay:.06s">
        <div class="card-body p-5 text-center">
            <div style="width:64px;height:64px;border-radius:18px;background:var(--teal-soft);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 16px;">
                <i class="bi bi-car-front"></i>
            </div>
            <h4 style="font-family:'Outfit',sans-serif;font-weight:700;margin-bottom:10px;">No Vehicles Registered</h4>
            <p style="color:var(--text-muted);max-width:460px;margin:0 auto 24px;font-size:14px;line-height:1.65;">
                You have not registered any vehicles yet. Register a vehicle to start offering rides and sharing your commute costs.
            </p>
            <a href="<?= $baseUrl ?>/vehicles/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Register a Vehicle
            </a>
        </div>
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($vehicles as $v): ?>
            <div class="col reveal" style="animation-delay:.06s">
                <div class="ride-card h-100" style="overflow:hidden;">
                    <!-- Vehicle Header -->
                    <?php if (!empty($v['photo'])): ?>
                        <div style="height:150px; background-image:url('<?= $baseUrl ?>/<?= htmlspecialchars($v['photo']) ?>'); background-size:cover; background-position:center; border-bottom:1px solid var(--border);"></div>
                    <?php else: ?>
                        <div style="background:linear-gradient(135deg,rgba(0,212,170,0.1),rgba(108,99,255,0.07));padding:32px;text-align:center;border-bottom:1px solid var(--border);">
                            <i class="bi bi-car-front-fill" style="font-size:3.5rem;color:var(--teal);filter:drop-shadow(0 0 12px rgba(0,212,170,0.4));"></i>
                        </div>
                    <?php endif; ?>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 style="font-family:'Outfit',sans-serif;font-weight:700;margin-bottom:5px;color:var(--text);"><?= htmlspecialchars($v['model']) ?></h5>
                                <span class="badge badge-accent mono" style="font-size:11px;letter-spacing:.04em;"><?= htmlspecialchars($v['registration_number']) ?></span>
                            </div>
                            <span class="badge badge-teal"><?= $v['seating_capacity'] ?> Seats</span>
                        </div>

                        <div class="d-flex gap-2 mt-4 pt-3" style="border-top:1px solid var(--border);">
                            <a href="<?= $baseUrl ?>/vehicles/<?= $v['id'] ?>/edit" class="btn btn-glass btn-sm flex-grow-1" style="justify-content:center;">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="<?= $baseUrl ?>/vehicles/<?= $v['id'] ?>/delete" method="POST" class="flex-grow-1" onsubmit="return confirm('Are you sure you want to remove this vehicle?');">
                                <button type="submit" class="btn btn-danger btn-sm w-100" style="justify-content:center;">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
