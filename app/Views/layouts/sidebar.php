<!-- Desktop Sidebar Sidebar Panel -->
<aside class="col-auto col-lg-3 col-xl-2 px-sm-2 px-0 bg-dark d-none d-lg-block shadow-lg border-end border-secondary" id="sidebar">
    <div class="d-flex flex-column align-items-stretch px-3 pt-3 text-white min-vh-100">
        <!-- Logo -->
        <a href="<?= $baseUrl ?>/dashboard" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none border-bottom border-secondary w-100">
            <i class="bi bi-car-front-fill fs-3 me-2 text-info"></i>
            <span class="fs-4 fw-extrabold text-gradient">Odoo</span>
        </a>
        
        <!-- Navigation Links -->
        <ul class="nav nav-pills flex-column mb-auto mt-4 gap-1 w-100" id="menu">
            <li class="nav-item">
                <a href="<?= $baseUrl ?>/dashboard" class="nav-link text-white text-start d-flex align-items-center py-2.5 px-3 rounded" id="side-nav-home">
                    <i class="bi bi-house-door fs-5 me-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= $baseUrl ?>/find-ride" class="nav-link text-white text-start d-flex align-items-center py-2.5 px-3 rounded" id="side-nav-find">
                    <i class="bi bi-search fs-5 me-3"></i>
                    <span>Find a Ride</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= $baseUrl ?>/offer-ride" class="nav-link text-white text-start d-flex align-items-center py-2.5 px-3 rounded" id="side-nav-offer">
                    <i class="bi bi-plus-circle fs-5 me-3"></i>
                    <span>Offer a Ride</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= $baseUrl ?>/my-trips" class="nav-link text-white text-start d-flex align-items-center py-2.5 px-3 rounded" id="side-nav-trips">
                    <i class="bi bi-calendar-event fs-5 me-3"></i>
                    <span>My Trips</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= $baseUrl ?>/wallet" class="nav-link text-white text-start d-flex align-items-center py-2.5 px-3 rounded" id="side-nav-wallet">
                    <i class="bi bi-wallet2 fs-5 me-3"></i>
                    <span>Wallet</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= $baseUrl ?>/vehicles" class="nav-link text-white text-start d-flex align-items-center py-2.5 px-3 rounded" id="side-nav-vehicles">
                    <i class="bi bi-car-front fs-5 me-3"></i>
                    <span>My Vehicles</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= $baseUrl ?>/reports" class="nav-link text-white text-start d-flex align-items-center py-2.5 px-3 rounded" id="side-nav-reports">
                    <i class="bi bi-bar-chart-line fs-5 me-3"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= $baseUrl ?>/settings" class="nav-link text-white text-start d-flex align-items-center py-2.5 px-3 rounded" id="side-nav-settings">
                    <i class="bi bi-gear fs-5 me-3"></i>
                    <span>Settings</span>
                </a>
            </li>
            
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li class="nav-item border-top border-secondary mt-3 pt-3">
                    <div class="text-uppercase text-muted fw-bold px-3 mb-2" style="font-size: 0.75rem;">Admin Panel</div>
                    <a href="<?= $baseUrl ?>/admin/dashboard" class="nav-link text-warning text-start d-flex align-items-center py-2.5 px-3 rounded" id="side-nav-admin">
                        <i class="bi bi-shield-lock fs-5 me-3"></i>
                        <span>Admin Overview</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        
        <!-- User Dropdown Profile -->
        <hr class="border-secondary mt-3 mb-3">
        <div class="dropdown pb-4">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2 fs-5 shadow-sm" style="width: 38px; height: 38px;">
                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                </div>
                <span class="d-none d-sm-inline mx-1 text-truncate" style="max-width: 100px;"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Employee') ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="<?= $baseUrl ?>/settings"><i class="bi bi-gear me-2"></i>Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?= $baseUrl ?>/logout"><i class="bi bi-box-arrow-right me-2"></i>Sign out</a></li>
            </ul>
        </div>
    </div>
</aside>

<!-- Content Wrapper -->
<main class="col flex-grow-1 p-3 p-lg-4 p-xl-5 min-vh-100 overflow-y-auto" id="content-area" style="padding-bottom: 70px !important;">
