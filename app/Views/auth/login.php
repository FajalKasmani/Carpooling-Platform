<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — UDAAN</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background-color: #0f172a;
            font-family: 'Inter', system-ui, sans-serif;
            color: #e2e8f0;
        }
        .login-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            max-width: 440px;
            width: 100%;
        }
        .text-gradient {
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            color: white;
        }
        .form-control {
            background-color: #0f172a;
            border-color: #334155;
            color: #f8fafc;
        }
        .form-control:focus {
            background-color: #0f172a;
            border-color: #38bdf8;
            color: #f8fafc;
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25);
        }
        .form-label {
            color: #94a3b8;
            font-weight: 500;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">

    <div class="login-card p-4 p-md-5">
        <div class="text-center mb-4">
            <h1 class="fw-extrabold display-5 mb-1"><i class="bi bi-car-front-fill me-2 text-gradient"></i>UDAAN</h1>
            <p class="text-muted">Enterprise Smart Carpooling Platform</p>
        </div>
        
        <?php if (!empty($flash)): ?>
            <div class="alert alert-danger border-0 text-white bg-danger bg-opacity-25" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>
        
        <form action="<?= $baseUrl ?>/login" method="POST" autocomplete="off">
            <div class="mb-3">
                <label for="email" class="form-label">Company Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary text-muted"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control border-start-0" id="email" name="email" required placeholder="name@company.com">
                </div>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary text-muted"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control border-start-0" id="password" name="password" required placeholder="••••••••">
                </div>
            </div>
            
            <button type="submit" class="btn btn-gradient w-100 py-2.5 fw-semibold mb-3 rounded-3">Sign In</button>
        </form>
        
        <div class="text-center">
            <span class="text-muted">New employee?</span>
            <a href="<?= $baseUrl ?>/register" class="text-info text-decoration-none fw-semibold ms-1">Register Account</a>
        </div>
    </div>

</body>
</html>
