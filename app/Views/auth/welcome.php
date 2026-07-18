<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UDAAN — Enterprise Carpooling Platform</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', system-ui, sans-serif;
            color: #1e293b;
            overflow-x: hidden;
        }
        .text-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: white;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
            color: white;
        }
        .feature-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        .feature-card:hover {
            transform: translateY(-6px);
            border-color: #6366f1;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid #e2e8f0;
            border-radius: 24px;
        }
        .hero-section {
            padding: 120px 0 80px 0;
            position: relative;
        }
        .hero-circle {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(255,255,255,0) 70%);
            top: -150px;
            right: -150px;
            z-index: -1;
        }
        .hero-circle-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.1) 0%, rgba(255,255,255,0) 70%);
            bottom: 0px;
            left: -100px;
            z-index: -1;
        }
        .nav-link-custom {
            color: #475569;
            font-weight: 500;
        }
        .nav-link-custom:hover {
            color: #6366f1;
        }
    </style>
</head>
<body>

    <div class="hero-circle"></div>
    <div class="hero-circle-2"></div>

    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent pt-4">
        <div class="container">
            <a class="navbar-brand fw-extrabold text-gradient fs-3" href="#">
                <i class="bi bi-car-front-fill me-2 text-gradient"></i>UDAAN
            </a>
            <div class="d-flex gap-3 align-items-center">
                <a href="<?= $baseUrl ?>/login" class="nav-link-custom text-decoration-none">Sign In</a>
                <a href="<?= $baseUrl ?>/register" class="btn btn-gradient px-4 rounded-pill fw-semibold">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Area -->
    <header class="hero-section text-center text-lg-start">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-6">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold border border-primary-subtle mb-3" style="font-size: 0.85rem;">
                        <i class="bi bi-shield-check me-2"></i>Enterprise verified only
                    </span>
                    <h1 class="display-4 fw-extrabold mb-3 lh-sm text-slate-900">
                        Smart Commuting for the <span class="text-gradient">Modern Employee</span>
                    </h1>
                    <p class="text-muted fs-5 mb-4 max-width-500">
                        Share rides, split travel expenses, network with teammates, and cut down your daily carbon footprint.
                    </p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                        <a href="<?= $baseUrl ?>/register" class="btn btn-gradient btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm">Get Started Now</a>
                        <a href="#features" class="btn btn-white border btn-lg px-4 py-3 rounded-pill fw-semibold text-dark shadow-sm">Learn More</a>
                    </div>
                </div>
                
                <div class="col-12 col-lg-6">
                    <div class="glass-panel p-4 p-md-5 text-center shadow-lg position-relative">
                        <div class="position-absolute top-0 start-50 translate-middle">
                             <div class="bg-gradient-primary rounded-circle p-3 text-white shadow-lg d-inline-block">
                                  <i class="bi bi-car-front-fill fs-1"></i>
                             </div>
                        </div>
                        <h3 class="fw-bold mb-2 mt-4 text-dark">Platform Status</h3>
                        <p class="text-muted" style="font-size: 0.95rem;">Empowering clean commutes across top organizations.</p>
                        
                        <div class="row g-3 text-center mt-4 pt-2">
                            <div class="col-4 border-end border-light-subtle">
                                <h4 class="fw-extrabold text-primary mb-1">30+</h4>
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">COMMUTERS</small>
                            </div>
                            <div class="col-4 border-end border-light-subtle">
                                <h4 class="fw-extrabold text-success mb-1">10+</h4>
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">VEHICLES</small>
                            </div>
                            <div class="col-4">
                                <h4 class="fw-extrabold text-warning mb-1">1.2k+</h4>
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">CO₂ SAVED (KG)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-5" id="features">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-5 mb-2 text-dark">Designed for the <span class="text-gradient">Ecosystem</span></h2>
                <p class="text-muted max-width-600 mx-auto">Discover modular tools optimized for daily corporate routines.</p>
            </div>
            
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="feature-card p-4 h-100">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 d-inline-flex justify-content-center align-items-center mb-4 fs-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-search"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-dark">Find a Ride</h4>
                        <p class="text-muted mb-0">Search and discover corporate commutes matching your schedule and book instantly with verified employees.</p>
                    </div>
                </div>
                
                <div class="col">
                    <div class="feature-card p-4 h-100">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 d-inline-flex justify-content-center align-items-center mb-4 fs-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-plus-circle"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-dark">Offer a Ride</h4>
                        <p class="text-muted mb-0">Publish routes with your registered vehicle, set custom seat fares, and start saving money while driving.</p>
                    </div>
                </div>
                
                <div class="col">
                    <div class="feature-card p-4 h-100">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 d-inline-flex justify-content-center align-items-center mb-4 fs-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-compass"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-dark">Live Trip GPS</h4>
                        <p class="text-muted mb-0">Real-time coordinates mapping, route directions, ETAs, and interactive group chats built directly into the app.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 border-top mt-5 bg-white">
        <div class="container text-center">
            <p class="text-muted mb-0" style="font-size: 0.85rem;">&copy; <?= date('Y') ?> Team UDAAN. Built with ❤️ for the Hackathon MVP.</p>
        </div>
    </footer>

</body>
</html>
