<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odoo — Enterprise Carpooling Platform</title>
    
    <!-- SVG Favicon Data URI -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🚗</text></svg>">
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
        
        /* 3D Animations & Enhancements */
        @keyframes float {
            0% { transform: perspective(1000px) translateY(0px) rotateX(0) rotateY(0); }
            50% { transform: perspective(1000px) translateY(-15px) rotateX(2deg) rotateY(-2deg); }
            100% { transform: perspective(1000px) translateY(0px) rotateX(0) rotateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
        }
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }

        .feature-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transform-style: preserve-3d;
            transform: perspective(1000px) translateZ(0);
        }
        .feature-card:hover {
            transform: perspective(1000px) translateZ(30px) translateY(-10px);
            border-color: #6366f1;
            box-shadow: 0 25px 35px -5px rgba(99, 102, 241, 0.15), 0 15px 15px -5px rgba(0, 0, 0, 0.04);
        }
        
        .feature-icon-3d {
            transition: transform 0.4s ease;
        }
        .feature-card:hover .feature-icon-3d {
            transform: translateZ(40px) scale(1.1);
            box-shadow: 0 15px 25px rgba(99, 102, 241, 0.2);
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            transform-style: preserve-3d;
            animation: float 8s ease-in-out infinite;
        }
        
        /* Hero Circles */
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
            animation: float 12s ease-in-out infinite alternate;
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
            animation: float 10s ease-in-out infinite alternate-reverse;
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
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent pt-4 animate-fade">
        <div class="container">
            <a class="navbar-brand fw-extrabold text-gradient fs-3" href="#">
                <i class="bi bi-car-front-fill me-2 text-gradient"></i>Odoo
            </a>
            <div class="d-flex gap-3 align-items-center">
                <a href="<?= $baseUrl ?? '' ?>/login" class="nav-link-custom text-decoration-none">Sign In</a>
                <a href="<?= $baseUrl ?? '' ?>/register" class="btn btn-gradient px-4 rounded-pill fw-semibold">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Area -->
    <header class="hero-section text-center text-lg-start">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-6 animate-fade delay-1">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold border border-primary-subtle mb-3 shadow-sm" style="font-size: 0.85rem;">
                        <i class="bi bi-shield-check me-2"></i>Enterprise verified only
                    </span>
                    <h1 class="display-4 fw-extrabold mb-3 lh-sm text-slate-900">
                        Smart Commuting for the <span class="text-gradient">Modern Employee</span>
                    </h1>
                    <p class="text-muted fs-5 mb-4 max-width-500">
                        Share rides, split travel expenses, network with teammates, and cut down your daily carbon footprint. Odoo connects your workplace natively to optimize everyone's daily journey.
                    </p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap">
                        <a href="<?= $baseUrl ?? '' ?>/register" class="btn btn-gradient btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm mb-2">Get Started Now</a>
                        <a href="#features" class="btn btn-white border btn-lg px-4 py-3 rounded-pill fw-semibold text-dark shadow-sm mb-2">Explore Features</a>
                    </div>
                </div>
                
                <div class="col-12 col-lg-6 animate-fade delay-2">
                    <div class="glass-panel p-4 p-md-5 text-center position-relative">
                        <div class="position-absolute top-0 start-50 translate-middle">
                             <div class="bg-gradient-primary rounded-circle p-3 text-white shadow-lg d-inline-block" style="transform: translateZ(20px);">
                                  <i class="bi bi-car-front-fill fs-1"></i>
                             </div>
                        </div>
                        <h3 class="fw-bold mb-2 mt-4 text-dark">Platform Impact Status</h3>
                        <p class="text-muted" style="font-size: 0.95rem;">Empowering clean, affordable, and safe commutes across our corporate networks.</p>
                        
                        <div class="row g-3 text-center mt-4 pt-2">
                            <div class="col-4 border-end border-light-subtle">
                                <h4 class="fw-extrabold text-primary mb-1">30+</h4>
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Active Commuters</small>
                            </div>
                            <div class="col-4 border-end border-light-subtle">
                                <h4 class="fw-extrabold text-success mb-1">10+</h4>
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Verified Vehicles</small>
                            </div>
                            <div class="col-4">
                                <h4 class="fw-extrabold text-warning mb-1">1.2k+</h4>
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">CO₂ Saved (KG)</small>
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
            <div class="text-center mb-5 animate-fade delay-1">
                <h2 class="fw-bold display-5 mb-2 text-dark">Designed for the <span class="text-gradient">Ecosystem</span></h2>
                <p class="text-muted max-width-600 mx-auto">Discover highly detailed modular tools optimized specifically for daily corporate routines and eco-friendly sustainability.</p>
            </div>
            
            <div class="row row-cols-1 row-cols-md-3 g-4 animate-fade delay-2">
                <div class="col">
                    <div class="feature-card p-4 h-100 text-center text-md-start">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 d-inline-flex justify-content-center align-items-center mb-4 fs-3 feature-icon-3d" style="width: 60px; height: 60px;">
                            <i class="bi bi-search"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-dark">Find a Ride Instantly</h4>
                        <p class="text-muted mb-0">Search and discover corporate commutes matching your schedule. View live seats, driver verification statuses, and book instantly with verified employees using an automated digital wallet.</p>
                    </div>
                </div>
                
                <div class="col">
                    <div class="feature-card p-4 h-100 text-center text-md-start">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 d-inline-flex justify-content-center align-items-center mb-4 fs-3 feature-icon-3d" style="width: 60px; height: 60px;">
                            <i class="bi bi-plus-circle"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-dark">Offer Routes & Save</h4>
                        <p class="text-muted mb-0">Publish routes with your registered vehicle, set custom seat fares, and start saving money while driving. The platform automatically calculates recommended fares based on corporate fuel prices.</p>
                    </div>
                </div>
                
                <div class="col">
                    <div class="feature-card p-4 h-100 text-center text-md-start">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 d-inline-flex justify-content-center align-items-center mb-4 fs-3 feature-icon-3d" style="width: 60px; height: 60px;">
                            <i class="bi bi-compass"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-dark">Live Trip GPS & Chat</h4>
                        <p class="text-muted mb-0">Real-time coordinates mapping, intelligent route directions, ETAs, and interactive group chats built directly into the app so you never lose contact with your fellow riders.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 border-top mt-5 bg-white">
        <div class="container text-center animate-fade delay-1">
            <p class="text-muted fw-semibold mb-0" style="font-size: 0.95rem;">
                &copy; <?= date('Y') ?> Odoo. Built with ❤️ <br> 
                <span class="text-gradient fw-bold">Odoo x KSV Hackathon</span>
            </p>
        </div>
    </footer>

</body>
</html>
