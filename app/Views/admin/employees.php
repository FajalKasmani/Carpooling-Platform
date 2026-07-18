<?php
$title = "Admin Dashboard - Employees";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';

// Mock data for UI presentation based on wireframes
$mockDepartments = ['Engineering', 'Sales', 'HR', 'Marketing', 'Finance'];
$mockManagers = ['A. Shah', 'R. Mehta', 'P. Desai', 'S. Patel'];
$mockLocations = ['Ahmedabad', 'Gandhinagar', 'Vadodara'];
?>

<!-- Unified Admin Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 48px; height: 48px; font-size: 1.2rem;">
            <?= strtoupper(substr($stats['org']['name'] ?? 'C', 0, 1)) ?>
        </div>
        <h4 class="mb-0 fw-bold text-dark"><?= htmlspecialchars($stats['org']['name'] ?? 'Company Name') ?></h4>
    </div>
    <div>
        <span class="badge bg-danger rounded-pill px-3 py-2 fs-6">Admin</span>
    </div>
</div>

<!-- Unified Stats Panel -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="card border border-secondary-subtle shadow-sm rounded-0 h-100">
            <div class="card-body py-2 px-3">
                <div class="text-dark fw-semibold" style="font-size: 0.85rem;">Total Employees</div>
                <div class="fs-4 text-info fw-bold"><?= $stats['total_employees'] ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border border-secondary-subtle shadow-sm rounded-0 h-100">
            <div class="card-body py-2 px-3">
                <div class="text-dark fw-semibold" style="font-size: 0.85rem;">Registered Vehicles</div>
                <div class="fs-4 text-info fw-bold"><?= $stats['registered_vehicles'] ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border border-secondary-subtle shadow-sm rounded-0 h-100">
            <div class="card-body py-2 px-3">
                <div class="text-dark fw-semibold" style="font-size: 0.85rem;">Rides This Month</div>
                <div class="fs-4 text-info fw-bold"><?= $stats['total_rides'] ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Unified Tabs -->
<ul class="nav nav-tabs mb-0 border-bottom-0 gap-1" style="font-family: inherit;">
    <li class="nav-item">
        <a class="nav-link active rounded-0 border border-bottom-0 text-dark px-4 py-2" href="<?= $baseUrl ?>/admin/employees" style="font-size: 0.9rem;">Employees</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-secondary border rounded-0 px-4 py-2" href="<?= $baseUrl ?>/admin/vehicles" style="font-size: 0.9rem;">Vehicles</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-secondary border rounded-0 px-4 py-2" href="<?= $baseUrl ?>/admin/settings" style="font-size: 0.9rem;">Settings</a>
    </li>
</ul>

<!-- Tab Content Area -->
<div class="card border rounded-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-borderless table-striped align-middle mb-0" style="font-size: 0.85rem;">
                <thead>
                    <tr class="border-bottom text-info">
                        <th class="fw-normal py-3 ps-4">Name</th>
                        <th class="fw-normal py-3">Email</th>
                        <th class="fw-normal py-3">Department</th>
                        <th class="fw-normal py-3">Manager</th>
                        <th class="fw-normal py-3">Location</th>
                        <th class="fw-normal py-3 pe-4">Platform Access</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($employees)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No employees found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($employees as $index => $emp): 
                            // Deterministic mocking based on user ID to keep UI stable
                            $mockDept = $mockDepartments[$emp['id'] % count($mockDepartments)];
                            $mockMgr = $mockManagers[$emp['id'] % count($mockManagers)];
                            $mockLoc = $mockLocations[$emp['id'] % count($mockLocations)];
                            $isActive = $emp['status'] === 'active';
                        ?>
                        <tr class="border-bottom">
                            <td class="ps-4 text-dark"><?= htmlspecialchars($emp['name']) ?></td>
                            <td class="text-dark"><?= htmlspecialchars($emp['email']) ?></td>
                            <td class="text-dark"><?= $mockDept ?></td>
                            <td class="text-dark"><?= $mockMgr ?></td>
                            <td class="text-dark"><?= $mockLoc ?></td>
                            <td class="pe-4">
                                <?php if ($isActive): ?>
                                    <button class="btn btn-link p-0 text-success text-decoration-none" onclick="toggleAccess(<?= $emp['id'] ?>, 'inactive')" style="font-size: 0.85rem;">[Granted]</button>
                                <?php else: ?>
                                    <button class="btn btn-link p-0 text-danger text-decoration-none" onclick="toggleAccess(<?= $emp['id'] ?>, 'active')" style="font-size: 0.85rem;">[Revoked]</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-top">
            <button class="btn btn-outline-info rounded-0 text-info fw-semibold px-4 py-1" style="font-size: 0.85rem;">+ Add Employee</button>
        </div>
    </div>
</div>

<script>
async function toggleAccess(userId, newStatus) {
    if (!confirm(`Are you sure you want to change this employee's access status?`)) return;
    
    try {
        const res = await fetch('<?= $baseUrl ?>/admin/employees/' + userId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ status: newStatus })
        });
        const data = await res.json();
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.error || 'Failed to update access.');
        }
    } catch (err) {
        console.error(err);
        alert('An error occurred.');
    }
}
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
