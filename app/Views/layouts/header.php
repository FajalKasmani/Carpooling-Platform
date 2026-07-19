<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) . ' — Odoo' : 'Odoo' ?></title>
    
    <!-- SVG Favicon Data URI -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🚗</text></svg>">
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
    <!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) . ' — Odoo' : 'Odoo' ?></title>
    
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🚗</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <!--<style>
        :root {
            --color-gold: #E5CB90;
            --color-cream: #FFF3C8;
            --color-blue: #34A99D;
            --color-rose: #458393;
}
        /* Navbar styling with palette */
        .navbar { background-color: var(--color-cream) !important; border-bottom: 3px solid var(--color-gold); }
        .nav-link { color: var(--color-rose) !important; font-weight: 600; }
        .nav-link:hover { color: var(--color-blue) !important; }
        .navbar-brand { color: var(--color-rose) !important; font-weight: 800; }
    </style>-->
</head>
<body class="d-flex flex-column h-100 bg-light">
    
    <!-- Unified Horizontal Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= $baseUrl ?>/dashboard">
                <i class="bi bi-car-front-fill me-2" style="color: var(--color-blue);"></i>Odoo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/dashboard">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/find-ride">Find</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/offer-ride">Offer</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/my-trips">Trips</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/wallet">Wallet</a></li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link fw-bold" style="color: var(--color-blue) !important;" href="<?= $baseUrl ?>/admin/dashboard">Admin</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link text-danger" href="<?= $baseUrl ?>/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="container flex-grow-1 py-4">