<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — UDAAN</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', system-ui, sans-serif;
            color: #1e293b;
        }
        .register-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            max-width: 500px;
            width: 100%;
        }
        .text-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
            color: white;
        }
        .form-control {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #334155;
        }
        .form-control:focus {
            background-color: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
        }
        .form-label {
            color: #64748b;
            font-weight: 500;
            font-size: 0.9rem;
        }
        .input-group-text {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #94a3b8;
        }
        .input-group-text.bg-transparent {
            background-color: transparent !important;
        }
        .floating-shape {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(255,255,255,0) 70%);
            z-index: -1;
        }
        .floating-shape-1 { top: -100px; right: -100px; }
        .floating-shape-2 { bottom: -100px; left: -100px; background: radial-gradient(circle, rgba(168, 85, 247, 0.1) 0%, rgba(255,255,255,0) 70%); }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-3 position-relative overflow-hidden">

    <div class="floating-shape floating-shape-1"></div>
    <div class="floating-shape floating-shape-2"></div>

    <div class="register-card p-4 p-md-5 position-relative z-1 my-4">
        <div class="text-center mb-4 pb-2">
            <h1 class="fw-extrabold display-6 mb-2"><i class="bi bi-car-front-fill me-2 text-gradient"></i>UDAAN</h1>
            <p class="text-muted" style="font-size: 0.95rem;">Join your corporate carpool network</p>
        </div>
        
        <?php if (!empty($flash['error'])): ?>
            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger fw-semibold rounded-3 mb-4 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= htmlspecialchars($flash['error']) ?>
            </div>
        <?php endif; ?>
                
        <form action="<?= $baseUrl ?>/register" method="POST" autocomplete="off">
            <div class="row g-3 mb-3">
                <div class="col-sm-12">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" id="name" name="name" required placeholder="John Doe">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Company Email</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" required placeholder="name@company.com">
                </div>
                <div class="form-text" style="font-size: 0.8rem;">Your organization will be auto-detected via email domain.</div>
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
            
            <button type="submit" class="btn btn-gradient w-100 py-2.5 fw-semibold mb-4 rounded-pill fs-6 shadow-sm">Create Account</button>
        </form>
        
        <div class="text-center mt-2">
            <span class="text-muted" style="font-size: 0.9rem;">Already have an account?</span>
            <a href="<?= $baseUrl ?>/login" class="text-primary text-decoration-none fw-bold ms-1" style="font-size: 0.9rem;">Sign In</a>
        </div>
    </div>

</body>
</html>
