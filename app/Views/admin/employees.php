<?php
$title = "Employee Management";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold text-gradient" style="background: linear-gradient(135deg, #f59e0b, #d97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><i class="bi bi-people-fill me-2"></i>Employee Directory</h1>
    <a href="<?= $baseUrl ?>/admin/dashboard" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-2"></i>Admin Dashboard</a>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-shield-check text-primary me-2"></i>Manage Access Permissions</h5>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle border-0">
            <thead class="table-light">
                <tr>
                    <th class="border-0 rounded-start">Name</th>
                    <th class="border-0">Email</th>
                    <th class="border-0">Phone</th>
                    <th class="border-0">Wallet Balance</th>
                    <th class="border-0">Role</th>
                    <th class="border-0 text-end rounded-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $emp): ?>
                    <tr>
                        <td class="fw-bold text-dark"><?= htmlspecialchars($emp['name']) ?></td>
                        <td><?= htmlspecialchars($emp['email']) ?></td>
                        <td><?= htmlspecialchars($emp['phone']) ?></td>
                        <td>₹<?= number_format($emp['wallet_balance'], 2) ?></td>
                        <td>
                            <span class="badge rounded-pill text-uppercase px-2.5 py-1 fw-bold bg-<?= $emp['role'] === 'admin' ? 'warning text-dark border-warning-subtle' : 'secondary border-secondary-subtle' ?> border" style="font-size: 0.65rem;">
                                <?= $emp['role'] ?>
                            </span>
                        </td>
                        <td class="text-end">
                            <?php if ($emp['id'] !== $_SESSION['user_id']): ?>
                                <button type="button" class="btn btn-<?= $emp['status'] === 'active' ? 'outline-danger' : 'success' ?> btn-sm rounded-3 toggle-status-btn" data-id="<?= $emp['id'] ?>" data-status="<?= $emp['status'] === 'active' ? 'inactive' : 'active' ?>">
                                    <?= $emp['status'] === 'active' ? '<i class="bi bi-slash-circle me-1"></i>Deactivate' : '<i class="bi bi-check-circle me-1"></i>Activate' ?>
                                </button>
                            <?php else: ?>
                                <span class="text-muted" style="font-size: 0.85rem;">Active (You)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.toggle-status-btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                const id = btn.dataset.id;
                const status = btn.dataset.status;
                
                if (!confirm(`Are you sure you want to make this employee ${status}?`)) return;
                
                const res = await fetchJSON(`/admin/employees/${id}`, {
                    method: 'POST',
                    body: JSON.stringify({ status: status })
                });
                
                if (res.success) {
                    showToast(res.message, 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast(res.error, 'error');
                }
            });
        });
    });
</script>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
