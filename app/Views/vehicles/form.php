<?php
$isEdit = !empty($vehicle);
$title  = $isEdit ? "Edit Vehicle" : "Add Vehicle";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon" style="background:var(--teal-soft);color:var(--teal);">
            <i class="bi bi-car-front"></i>
        </span>
        <?= $title ?>
    </div>
    <a href="<?= $baseUrl ?>/vehicles" class="btn btn-glass btn-sm">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-6">
        <div class="card p-4 p-md-5 reveal" style="animation-delay:.06s">
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:24px;display:flex;align-items:center;gap:9px;">
                <i class="bi bi-car-front-fill" style="color:var(--teal);"></i> Vehicle Specifications
            </h5>

            <?php if (!empty($flash)): 
                $msg = is_string($flash) ? $flash : ($flash['message'] ?? $flash['error'] ?? 'An error occurred');
            ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($msg) ?>
                </div>
            <?php endif; ?>

            <form action="<?= $baseUrl ?>/vehicles<?= $isEdit ? '/' . $vehicle['id'] . '/update' : '' ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="model" class="form-label">Vehicle Model</label>
                    <input type="text" class="form-control" id="model" name="model" required
                           placeholder="e.g. Honda City, Maruti Swift"
                           value="<?= $isEdit ? htmlspecialchars($vehicle['model']) : '' ?>">
                </div>

                <div class="mb-3">
                    <label for="registration_number" class="form-label">Registration Number</label>
                    <input type="text" class="form-control" id="registration_number" name="registration_number" required
                           placeholder="e.g. GJ01AB1234"
                           value="<?= $isEdit ? htmlspecialchars($vehicle['registration_number']) : '' ?>">
                    <div class="form-text" style="color:var(--text-faint);font-size:11px;margin-top:6px;">Should be unique and follow regional format.</div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <label for="seating_capacity" class="form-label">Seating Capacity</label>
                        <select class="form-select" id="seating_capacity" name="seating_capacity" required>
                            <option value="2" <?= $isEdit && (int)$vehicle['seating_capacity'] === 2 ? 'selected' : '' ?>>2 Persons</option>
                            <option value="3" <?= $isEdit && (int)$vehicle['seating_capacity'] === 3 ? 'selected' : '' ?>>3 Persons</option>
                            <option value="4" <?= $isEdit && (int)$vehicle['seating_capacity'] === 4 ? 'selected' : '' ?>>4 Persons</option>
                            <option value="5" <?= !$isEdit || (int)$vehicle['seating_capacity'] === 5 ? 'selected' : '' ?>>5 Persons</option>
                            <option value="7" <?= $isEdit && (int)$vehicle['seating_capacity'] === 7 ? 'selected' : '' ?>>7 Persons</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="photo" class="form-label">Vehicle Photo (Optional)</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                        <?php if ($isEdit && !empty($vehicle['photo'])): ?>
                            <div class="mt-2">
                                <small class="text-muted d-block mb-1">Current Photo:</small>
                                <img src="<?= $baseUrl ?>/<?= htmlspecialchars($vehicle['photo']) ?>" alt="Vehicle Photo" style="max-height:80px; border-radius:var(--radius-sm);">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="bi bi-check-circle"></i> <?= $isEdit ? 'Update Vehicle' : 'Register Vehicle' ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
