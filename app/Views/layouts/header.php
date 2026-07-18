<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) . ' — UDAAN' : 'UDAAN — Enterprise Carpooling' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <!-- Leaflet CSS (Map) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
</head>
<body class="d-flex flex-column h-100 bg-light">
    
    <!-- Top Navbar for Mobile -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-lg-none sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-gradient" href="<?= $baseUrl ?>/dashboard">
                <i class="bi bi-car-front-fill me-2 text-info"></i>UDAAN
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mobileNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $baseUrl ?>/dashboard"><i class="bi bi-house-door me-2"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $baseUrl ?>/find-ride"><i class="bi bi-search me-2"></i>Find Ride</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $baseUrl ?>/offer-ride"><i class="bi bi-plus-circle me-2"></i>Offer Ride</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $baseUrl ?>/my-trips"><i class="bi bi-calendar-event me-2"></i>My Trips</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $baseUrl ?>/wallet"><i class="bi bi-wallet2 me-2"></i>Wallet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $baseUrl ?>/vehicles"><i class="bi bi-car-front me-2"></i>Vehicles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $baseUrl ?>/reports"><i class="bi bi-bar-chart-line me-2"></i>Reports</a>
                    </li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="<?= $baseUrl ?>/admin/dashboard"><i class="bi bi-shield-lock me-2"></i>Admin Panel</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item border-top mt-2 pt-2">
                        <a class="nav-link text-danger" href="<?= $baseUrl ?>/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- App Shell Layout -->
    <div class="container-fluid flex-grow-1 d-flex p-0">
        <div class="row g-0 flex-grow-1">
