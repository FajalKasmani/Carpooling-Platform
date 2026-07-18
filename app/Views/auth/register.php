<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Odoo</title>
    
    <!-- SVG Favicon Data URI -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🚗</text></svg>">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', system-ui, sans-serif;
            color: #1e293b;
            min-vh-100: 100vh;
        }
        
        .split-container {
            min-height: 100vh;
        }

        /* Left Side Brand Column */
        .brand-side {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: white;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        
        .brand-side::before {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            top: -100px;
            left: -100px;
        }
        
        .brand-side::after {
            content: "";
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            bottom: -100px;
            right: -100px;
        }

        .brand-logo {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            z-index: 2;
        }
        
        .brand-content {
            max-width: 460px;
            z-index: 2;
        }

        .info-pill {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 0.5rem 1.25rem;
            border-radius: 50rem;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 2rem;
            color: #ffffff;
        }

        .brand-features {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .feature-icon {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            width: 45px;
            height: 45px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        /* Right Side Form Column */
        .form-side {
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
        }

        .form-container {
            width: 100%;
            max-width: 440px;
        }

        .text-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-control {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.95rem;
            color: #1e293b;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        }

        .input-group-text {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            color: #94a3b8;
            padding-left: 1.25rem;
            padding-right: 0.75rem;
        }

        .form-label {
            color: #475569;
            font-weight: 600;
            font-size: 0.88rem;
            margin-bottom: 0.5rem;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: white;
            border: none;
            padding: 0.8rem;
            font-weight: 700;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(99, 102, 241, 0.35);
            color: white;
        }

        .btn-gradient:active {
            transform: translateY(0);
        }

        .brand-footer {
            z-index: 2;
            font-size: 0.85rem;
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <div class="container-fluid p-0">
        <div class="row g-0 split-container">
            <!-- Left Branding Side -->
            <div class="col-lg-6 brand-side d-none d-lg-flex">
                <div class="brand-logo">
                    <i class="bi bi-car-front-fill me-2"></i>Odoo
                </div>
                
                <div class="brand-content my-auto">
                    <span class="info-pill">
                        <i class="bi bi-shield-check me-2"></i>Verified Coworkers
                    </span>
                    <h1 class="display-5 fw-extrabold mb-3 lh-sm">
                        Start your smart commuting journey today.
                    </h1>
                    <p class="fs-5 opacity-90 mb-4">
                        Register your official company email and join thousands of corporate colleagues sharing routes.
                    </p>
                    
                    <div class="brand-features">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-check-circle"></i></div>
                            <div>
                                <h5 class="fw-bold mb-1 fs-6">Auto Organization Matching</h5>
                                <p class="small opacity-85 mb-0">Our platform automatically registers your profile to your corporate space using your email domain.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-credit-card"></i></div>
                            <div>
                                <h5 class="fw-bold mb-1 fs-6">Personal Carpool Wallet</h5>
                                <p class="small opacity-85 mb-0">Recharge, pay, and receive seat payouts directly inside the integrated digital wallet system.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-map"></i></div>
                            <div>
                                <h5 class="fw-bold mb-1 fs-6">Flexible Travel Roles</h5>
                                <p class="small opacity-85 mb-0">Seamlessly register vehicles to offer rides or instantly search available seats as a passenger.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="brand-footer mt-auto">
                    <p class="mb-0">&copy; <?= date('Y') ?> Odoo. Built for secure corporate rides.</p>
                </div>
            </div>
            
            <!-- Right Form Side -->
            <div class="col-12 col-lg-6 form-side">
                <div class="form-container">
                    <div class="d-flex align-items-center mb-4 d-lg-none">
                        <i class="bi bi-car-front-fill fs-1 text-gradient me-2"></i>
                        <h2 class="fw-extrabold text-gradient mb-0">Odoo</h2>
                    </div>

                    <div class="mb-4">
                        <h2 class="fw-extrabold text-dark">Get started</h2>
                        <p class="text-muted">Create your corporate commuter account in seconds</p>
                    </div>

                    <?php if (!empty($flash['error'])): ?>
                        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger fw-semibold rounded-3 mb-4 d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= htmlspecialchars($flash['error']) ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= $baseUrl ?>/register" method="POST" autocomplete="off">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="name" name="name" required placeholder="John Doe">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Company Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" required placeholder="name@company.com">
                            </div>
                            <div class="form-text mt-1 text-muted" style="font-size: 0.78rem;">Your organization will be auto-detected via email domain.</div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Mobile Number</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-telephone"></i></span>
                                <input type="tel" class="form-control border-start-0 ps-0" id="phone" name="phone" required placeholder="10-digit number">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" required minlength="8" placeholder="At least 8 characters">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-gradient w-100 py-2.5 fw-semibold mb-4 rounded-pill">Create Account</button>
                    </form>
                    
                    <div class="text-center">
                        <span class="text-muted small">Already have an account?</span>
                        <a href="<?= $baseUrl ?>/login" class="text-primary text-decoration-none fw-bold small ms-1">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
