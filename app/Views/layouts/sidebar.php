<!-- Desktop Sidebar -->
<aside class="col-auto d-none d-lg-flex flex-column p-0" id="sidebar">

    <!-- Brand Logo -->
    <a href="<?= $baseUrl ?>/dashboard" class="sidebar-brand">
        <svg viewBox="0 0 24 24" fill="none" stroke="#6C63FF" stroke-width="1.8">
            <path d="M3 16c3-6 5-9 9-9s6 3 9 9" stroke-linecap="round"/>
            <circle cx="6" cy="18" r="1.4" fill="#6C63FF" stroke="none"/>
            <circle cx="18" cy="18" r="1.4" fill="#00D4AA" stroke="none"/>
        </svg>
        RideShare
        <span class="sidebar-brand-dot ms-auto"></span>
    </a>

    <div class="flex-grow-1 pt-2 pb-2">
        <!-- Main -->
        <div class="nav-label">Navigate</div>
        <nav class="nav flex-column">
            <a href="<?= $baseUrl ?>/dashboard" class="nav-link" id="side-nav-home">
                <span class="nav-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></svg>
                </span>
                <span>Dashboard</span>
            </a>
            <a href="<?= $baseUrl ?>/find-ride" class="nav-link" id="side-nav-find">
                <span class="nav-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                </span>
                <span>Find a Ride</span>
            </a>
            <a href="<?= $baseUrl ?>/offer-ride" class="nav-link" id="side-nav-offer">
                <span class="nav-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/></svg>
                </span>
                <span>Offer a Ride</span>
            </a>
            <a href="<?= $baseUrl ?>/my-trips" class="nav-link" id="side-nav-trips">
                <span class="nav-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                </span>
                <span>My Trips</span>
            </a>
        </nav>

        <!-- Finance -->
        <div class="nav-label mt-2">Finance</div>
        <nav class="nav flex-column">
            <a href="<?= $baseUrl ?>/wallet" class="nav-link" id="side-nav-wallet">
                <span class="nav-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M16 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" fill="currentColor" stroke="none"/></svg>
                </span>
                <span>Wallet</span>
            </a>
            <a href="<?= $baseUrl ?>/vehicles" class="nav-link" id="side-nav-vehicles">
                <span class="nav-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 13l1.5-5A2 2 0 0 1 6.4 6.5h11.2a2 2 0 0 1 1.9 1.5L21 13"/><rect x="3" y="13" width="18" height="6" rx="1.5"/><circle cx="7.5" cy="19" r="1"/><circle cx="16.5" cy="19" r="1"/></svg>
                </span>
                <span>My Vehicles</span>
            </a>
            <a href="<?= $baseUrl ?>/reports" class="nav-link" id="side-nav-reports">
                <span class="nav-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 3v18h18"/><path d="M7 16l4-5 4 3 4-6"/></svg>
                </span>
                <span>Reports</span>
            </a>
        </nav>

        <!-- Account -->
        <div class="nav-label mt-2">Account</div>
        <nav class="nav flex-column">
            <a href="<?= $baseUrl ?>/settings" class="nav-link" id="side-nav-settings">
                <span class="nav-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                </span>
                <span>Settings</span>
            </a>
        </nav>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <hr class="sidebar-divider mt-2">
        <div class="nav-label">Admin</div>
        <nav class="nav flex-column">
            <a href="<?= $baseUrl ?>/admin/dashboard" class="nav-link admin-link" id="side-nav-admin">
                <span class="nav-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </span>
                <span>Admin Panel</span>
            </a>
        </nav>
        <?php endif; ?>
    </div>

    <!-- User profile -->
    <div class="sidebar-user-block">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle"
               id="sidebarUser" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar">
                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="overflow-hidden lh-sm">
                    <div class="fw-semibold text-truncate" style="font-size:13px;max-width:148px;color:var(--text);">
                        <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
                    </div>
                    <div style="font-size:10.5px;color:var(--text-muted);">
                        <?= ucfirst($_SESSION['role'] ?? 'member') ?>
                    </div>
                </div>
            </a>
            <ul class="dropdown-menu text-small shadow mb-1"
                aria-labelledby="sidebarUser">
                <li><a class="dropdown-item" href="<?= $baseUrl ?>/settings">
                    <i class="bi bi-gear me-2"></i>Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?= $baseUrl ?>/logout">
                    <i class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
            </ul>
        </div>
    </div>
</aside>

<!-- Main Content -->
<main class="col flex-grow-1 p-3 p-lg-4 p-xl-5 overflow-y-auto" id="content-area" style="padding-bottom:80px!important;">
