<?php
$title = "Admin Dashboard - Employees";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';

$mockDepartments = ['Engineering', 'Sales', 'HR', 'Marketing', 'Finance'];
$mockManagers = ['A. Shah', 'R. Mehta', 'P. Desai', 'S. Patel'];
$mockLocations = ['Ahmedabad', 'Gandhinagar', 'Vadodara'];
?>

<!-- Admin Header -->
<div class="d-flex justify-content-between align-items-center mb-4 reveal">
    <div class="d-flex align-items-center gap-3">
        <div style="width:48px;height:48px;border-radius:14px;background:rgba(245,158,11,0.15);color:#F59E0B;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;font-family:'Outfit',sans-serif;">
            <?= strtoupper(substr($stats['org']['name'] ?? 'C', 0, 1)) ?>
        </div>
        <div>
            <h4 style="font-family:'Outfit',sans-serif;font-weight:700;margin:0;"><?= htmlspecialchars($stats['org']['name'] ?? 'Company Name') ?></h4>
            <span style="font-size:11px;color:var(--text-faint);">Organization Directory</span>
        </div>
    </div>
    <span class="badge badge-red">Admin</span>
</div>

<!-- Admin Stats -->
<div class="row g-3 mb-4 reveal" style="animation-delay:.04s">
    <div class="col-4">
        <div class="stat-card p-3 text-center">
            <div class="stat-label mb-1">Total Employees</div>
            <div class="stat-value mono" style="color:var(--teal);"><?= $stats['total_employees'] ?></div>
        </div>
    </div>
    <div class="col-4">
        <div class="stat-card p-3 text-center">
            <div class="stat-label mb-1">Registered Vehicles</div>
            <div class="stat-value mono" style="color:var(--accent);"><?= $stats['registered_vehicles'] ?></div>
        </div>
    </div>
    <div class="col-4">
        <div class="stat-card p-3 text-center">
            <div class="stat-label mb-1">Rides This Month</div>
            <div class="stat-value mono" style="color:var(--yellow);"><?= $stats['total_rides'] ?></div>
        </div>
    </div>
</div>

<!-- Tabs -->
<div class="d-flex gap-2 mb-4 reveal" style="animation-delay:.06s">
    <a href="<?= $baseUrl ?>/admin/employees" class="btn btn-primary btn-sm"><i class="bi bi-people"></i> Employees</a>
    <a href="<?= $baseUrl ?>/admin/vehicles" class="btn btn-glass btn-sm"><i class="bi bi-car-front"></i> Vehicles</a>
    <a href="<?= $baseUrl ?>/admin/settings" class="btn btn-glass btn-sm"><i class="bi bi-sliders"></i> Settings</a>
</div>

<!-- Employee Table -->
<div class="card reveal" style="animation-delay:.08s">
    <div class="card-body p-4">
        <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <i class="bi bi-people-fill" style="color:var(--accent);"></i> Employee Directory
        </h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Manager</th>
                        <th>Location</th>
                        <th class="text-end">Platform Access</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($employees)): ?>
                        <tr><td colspan="6" class="text-center py-5" style="color:var(--text-muted);">No employees found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($employees as $index => $emp):
                            $mockDept = $mockDepartments[$emp['id'] % count($mockDepartments)];
                            $mockMgr = $mockManagers[$emp['id'] % count($mockManagers)];
                            $mockLoc = $mockLocations[$emp['id'] % count($mockLocations)];
                            $isActive = $emp['status'] === 'active';
                        ?>
                        <tr>
                            <td style="font-weight:600;"><?= htmlspecialchars($emp['name']) ?></td>
                            <td style="color:var(--text-muted);font-size:12.5px;"><?= htmlspecialchars($emp['email']) ?></td>
                            <td><span class="badge badge-accent"><?= $mockDept ?></span></td>
                            <td><?= $mockMgr ?></td>
                            <td><?= $mockLoc ?></td>
                            <td class="text-end">
                                <?php if ($isActive): ?>
                                    <button class="btn btn-teal btn-sm" onclick="toggleAccess(<?= $emp['id'] ?>, 'inactive')">Granted ✓</button>
                                <?php else: ?>
                                    <button class="btn btn-danger btn-sm" onclick="toggleAccess(<?= $emp['id'] ?>, 'active')">Revoked ✗</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Password Resets Section -->
<div class="card mt-4 reveal" style="animation-delay:.12s">
    <div class="card-body p-4">
        <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:5px;display:flex;align-items:center;gap:8px;">
            <i class="bi bi-shield-lock" style="color:var(--yellow);"></i> Password Reset Requests
        </h5>
        <p style="color:var(--text-muted);font-size:12.5px;margin-bottom:20px;">Users who have requested a password recovery. Provide them the 4-digit code to allow them to reset their password.</p>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Request Email</th>
                        <th>Generated Code</th>
                        <th>Requested At</th>
                        <th class="text-end">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($resetRequests)): ?>
                        <tr><td colspan="4" class="text-center py-5" style="color:var(--text-muted);">No pending password reset requests.</td></tr>
                    <?php else: ?>
                        <?php foreach ($resetRequests as $req): ?>
                        <tr>
                            <td class="mono" style="font-weight:600;"><?= htmlspecialchars($req['email']) ?></td>
                            <td>
                                <span class="badge badge-yellow mono px-4 py-2" style="font-size:16px;font-weight:700;letter-spacing:4px;"><?= $req['code'] ?></span>
                            </td>
                            <td style="color:var(--text-muted);font-size:12.5px;"><?= $req['created_at'] ?></td>
                            <td class="text-end">
                                <?php if ($req['status'] === 'pending'): ?>
                                    <span class="badge badge-orange">Awaiting Verification</span>
                                <?php else: ?>
                                    <span class="badge badge-green">Code Verified</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
async function toggleAccess(userId, newStatus) {
    if (!confirm(`Are you sure you want to change this employee's access status?`)) return;
    try {
        const res = await fetch('<?= $baseUrl ?>/admin/employees/' + userId, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify({ status: newStatus })
        });
        const data = await res.json();
        if (data.success) { window.location.reload(); }
        else { alert(data.error || 'Failed to update access.'); }
    } catch (err) { console.error(err); alert('An error occurred.'); }
}
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
