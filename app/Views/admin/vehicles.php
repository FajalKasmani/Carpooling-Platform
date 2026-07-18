<?php
$title = "Fleet moderation";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold text-gradient" style="background: linear-gradient(135deg, #f59e0b, #d97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><i class="bi bi-car-front-fill me-2"></i>Fleet Moderation</h1>
    <a href="<?= $baseUrl ?>/admin/dashboard" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-2"></i>Admin Dashboard</a>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-shield-check text-primary me-2"></i>Fleet Directory</h5>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle border-0">
            <thead class="table-light">
                <tr>
                    <th class="border-0 rounded-start">Vehicle Detail</th>
                    <th class="border-0">Registration Number</th>
                    <th class="border-0">Owner (Employee)</th>
                    <th class="border-0">Capacity</th>
                    <th class="border-0 text-end rounded-end">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($vehicles)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-car-front fs-2 mb-2 d-block text-secondary opacity-50"></i>
                            No vehicles registered under this organization.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($vehicles as $v): ?>
                        <tr>
                            <td class="fw-bold text-dark">
                                <i class="bi bi-car-front me-2 text-primary"></i><?= htmlspecialchars($v['model']) ?>
                            </td>
                            <td><span class="badge bg-dark rounded-pill"><?= htmlspecialchars($v['registration_number']) ?></span></td>
                            <td>
                                <span class="fw-semibold text-dark d-block"><?= htmlspecialchars($v['owner_name']) ?></span>
                                <small class="text-muted"><?= htmlspecialchars($v['owner_email']) ?></small>
                            </td>
                            <td><?= $v['seating_capacity'] ?> Seats</td>
                            <td class="text-end">
                                <span class="badge rounded-pill px-2.5 py-1.5 fw-bold bg-<?= $v['status'] === 'active' ? 'success' : 'danger' ?> bg-opacity-10 text-<?= $v['status'] === 'active' ? 'success' : 'danger' ?> border border-<?= $v['status'] === 'active' ? 'success-subtle' : 'danger-subtle' ?>" style="font-size: 0.65rem;">
                                    <?= $v['status'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
