<?php
$title = "My Vehicles";
require_once dirname(__DIR__) . '/layouts/header.php';
//require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-car-front me-2 text-primary"></i>My Vehicles</h1>
    <a href="<?= $baseUrl ?>/vehicles/create" class="btn btn-primary fw-bold"><i class="bi bi-plus-circle me-2"></i>Add Vehicle</a>
</div>

<?php if (empty($vehicles)): ?>
    <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4">
        <i class="bi bi-car-front fs-1 text-muted mb-3"></i>
        <h4 class="fw-bold">No Vehicles Registered</h4>
        <p class="text-muted max-width-500 mx-auto mb-4">You have not registered any vehicles yet. Register a vehicle to start offering rides and sharing your commute costs.</p>
        <a href="<?= $baseUrl ?>/vehicles/create" class="btn btn-primary fw-bold px-4 py-2.5 rounded-3 shadow-sm">
            <i class="bi bi-plus-circle me-2"></i>Register a Vehicle
        </a>
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($vehicles as $v): ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden ride-card">
                    <div class="bg-primary bg-opacity-10 py-4 text-center border-bottom border-light">
                        <i class="bi bi-car-front-fill text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($v['model']) ?></h5>
                                <span class="badge bg-secondary rounded-pill"><?= htmlspecialchars($v['registration_number']) ?></span>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5 fw-semibold border border-success-subtle">
                                <?= $v['seating_capacity'] ?> Seats
                            </span>
                        </div>
                        
                        <div class="d-flex gap-2 mt-4 pt-2 border-top border-light">
                            <a href="<?= $baseUrl ?>/vehicles/<?= $v['id'] ?>/edit" class="btn btn-outline-primary btn-sm flex-grow-1 fw-semibold rounded-3 py-2">
                                <i class="bi bi-pencil-square me-2"></i>Edit
                            </a>
                            <form action="<?= $baseUrl ?>/vehicles/<?= $v['id'] ?>/delete" method="POST" class="flex-grow-1" onsubmit="return confirm('Are you sure you want to remove this vehicle?');">
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-semibold rounded-3 py-2">
                                    <i class="bi bi-trash me-2"></i>Delete
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
