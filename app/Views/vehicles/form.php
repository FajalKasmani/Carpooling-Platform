<?php
$isEdit = !empty($vehicle);
$title  = $isEdit ? "Edit Vehicle" : "Add Vehicle";
require_once dirname(__DIR__) . '/layouts/header.php';
//require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-car-front me-2 text-primary"></i><?= $title ?></h1>
    <a href="<?= $baseUrl ?>/vehicles" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
</div>

<div class="row">
    <div class="col-12 col-lg-6 mx-auto">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-car-front-fill me-2 text-primary"></i>Vehicle Specifications</h5>
            
            <?php if (!empty($flash)): ?>
                <div class="alert alert-danger border-0 text-white bg-danger bg-opacity-25" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($flash['message']) ?>
                </div>
            <?php endif; ?>
            
            <form action="<?= $baseUrl ?>/vehicles<?= $isEdit ? '/' . $vehicle['id'] . '/update' : '' ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="model" class="form-label fw-semibold text-muted">Vehicle Model</label>
                    <input type="text" class="form-control py-2.5 rounded-3" id="model" name="model" required placeholder="e.g. Honda City, Maruti Swift" value="<?= $isEdit ? htmlspecialchars($vehicle['model']) : '' ?>">
                </div>
                
                <div class="mb-3">
                    <label for="registration_number" class="form-label fw-semibold text-muted">Registration Number</label>
                    <input type="text" class="form-control py-2.5 rounded-3" id="registration_number" name="registration_number" required placeholder="e.g. GJ01AB1234" value="<?= $isEdit ? htmlspecialchars($vehicle['registration_number']) : '' ?>">
                    <div class="form-text text-muted" style="font-size: 0.75rem;">Should be unique and follow regional format.</div>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <label for="seating_capacity" class="form-label fw-semibold text-muted">Seating Capacity</label>
                        <select class="form-select py-2.5 rounded-3" id="seating_capacity" name="seating_capacity" required>
                            <option value="2" <?= $isEdit && (int)$vehicle['seating_capacity'] === 2 ? 'selected' : '' ?>>2 Persons</option>
                            <option value="3" <?= $isEdit && (int)$vehicle['seating_capacity'] === 3 ? 'selected' : '' ?>>3 Persons</option>
                            <option value="4" <?= $isEdit && (int)$vehicle['seating_capacity'] === 4 ? 'selected' : '' ?>>4 Persons</option>
                            <option value="5" <?= !$isEdit || (int)$vehicle['seating_capacity'] === 5 ? 'selected' : '' ?>>5 Persons</option>
                            <option value="7" <?= $isEdit && (int)$vehicle['seating_capacity'] === 7 ? 'selected' : '' ?>>7 Persons</option>
                        </select>
                    </div>
                    
                    <div class="col-6">
                        <label for="photo" class="form-label fw-semibold text-muted">Vehicle Photo (Optional)</label>
                        <input type="file" class="form-control py-2 rounded-3" id="photo" name="photo" accept="image/*">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-3 shadow-sm py-2.5">
                    <i class="bi bi-check-circle me-2"></i><?= $isEdit ? 'Update Vehicle' : 'Register Vehicle' ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
