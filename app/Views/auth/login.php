<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — RideShare</title>
    <link rel="icon" type="image/svg+xml" href="<?= $baseUrl ?>/favicon.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
</head>
<body>

<div class="auth-page">
    <!-- Left panel -->
    <div class="auth-panel">
        <a href="<?= $baseUrl ?>" class="auth-logo">
            <svg viewBox="0 0 24 24" fill="none" stroke="#6C63FF" stroke-width="1.8">
                <path d="M3 16c3-6 5-9 9-9s6 3 9 9" stroke-linecap="round"/>
                <circle cx="6" cy="18" r="1.4" fill="#6C63FF" stroke="none"/>
                <circle cx="18" cy="18" r="1.4" fill="#00D4AA" stroke="none"/>
            </svg>
            RideShare
        </a>

        <div class="auth-copy">
            <h2>Connect with your coworkers, share the ride.</h2>
            <p>Sign in with your company email to find or offer commutes with verified colleagues.</p>
            <div class="auth-points">
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div>
                        <div class="pt">Route matching</div>
                        <div class="ps">Calculates driving paths and connects verified colleagues automatically.</div>
                    </div>
                </div>
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div>
                        <div class="pt">Shared wallet</div>
                        <div class="ps">Fare splitting is handled inside your prepaid company wallet.</div>
                    </div>
                </div>
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div>
                        <div class="pt">Impact tracking</div>
                        <div class="ps">See kilometers shared and CO₂ saved across every trip.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-foot">&copy; <?= date('Y') ?> RideShare &middot; Built for secure corporate rides</div>

        <!-- Animated route decoration -->
        <svg class="auth-route-svg" viewBox="0 0 300 170" fill="none">
            <path d="M6 150 C 80 150, 70 40, 150 40 S 240 110, 294 20"
                  stroke="url(#authGrad)" stroke-width="1.5" stroke-linecap="round" opacity=".5"/>
            <defs>
                <linearGradient id="authGrad" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0%" stop-color="#6C63FF"/>
                    <stop offset="100%" stop-color="#00D4AA"/>
                </linearGradient>
            </defs>
            <circle r="4" fill="#6C63FF" opacity=".9">
                <animateMotion dur="4s" repeatCount="indefinite" path="M6 150 C 80 150, 70 40, 150 40 S 240 110, 294 20"/>
            </circle>
        </svg>
    </div>

    <!-- Right form side -->
    <div class="auth-form-side">
        <div class="auth-form-wrap">
            <h2>Welcome back</h2>
            <p>Enter your company email to access your account.</p>

            <?php if (!empty($flash['error'])): ?>
            <div class="auth-alert error">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                <?= htmlspecialchars($flash['error']) ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($flash['success'])): ?>
            <div class="auth-alert success">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                <?= htmlspecialchars($flash['success']) ?>
            </div>
            <?php endif; ?>

            <form action="<?= $baseUrl ?>/login" method="POST" autocomplete="off">

                <div class="auth-field">
                    <label class="auth-label">Company email</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/>
                        </svg>
                        <input type="email" name="email" id="email" required placeholder="name@company.com">
                    </div>
                </div>

                <div class="auth-field">
                    <div class="auth-label-row">
                        <label class="auth-label">Password</label>
                        <a href="<?= $baseUrl ?>/forgot-password" class="auth-label-link">Forgot password?</a>
                    </div>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="4" y="10" width="16" height="10" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/>
                        </svg>
                        <input type="password" name="password" id="password" required placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="auth-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Sign in
                </button>
            </form>

            <div class="auth-foot-link">
                New to the platform? <a href="<?= $baseUrl ?>/register">Create an account</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
