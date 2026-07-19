<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — RideShare</title>
    <link rel="icon" type="image/svg+xml" href="<?= $baseUrl ?>/favicon.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
</head>
<body>

<div class="auth-page">
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
            <h2>Reset access to your account.</h2>
            <p>We'll route your request to your organization's administrator for approval.</p>
            <div class="auth-points">
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div><div class="pt">Admin-reviewed</div><div class="ps">Resets are approved by your company's platform administrator.</div></div>
                </div>
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div><div class="pt">Verified email only</div><div class="ps">Requests only go through for a registered company address.</div></div>
                </div>
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div><div class="pt">4-digit code process</div><div class="ps">Admin shares a code with you — enter it on the next screen to set your new password.</div></div>
                </div>
            </div>
        </div>
        <div class="auth-foot">&copy; <?= date('Y') ?> RideShare &middot; Built for secure corporate rides</div>
        <svg class="auth-route-svg" viewBox="0 0 300 170" fill="none">
            <path d="M6 150 C 80 150, 70 40, 150 40 S 240 110, 294 20" stroke="url(#fpGrad)" stroke-width="1.5" stroke-linecap="round"/>
            <defs><linearGradient id="fpGrad" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#6C63FF"/><stop offset="100%" stop-color="#00D4AA"/></linearGradient></defs>
            <circle r="4" fill="#6C63FF" opacity=".9"><animateMotion dur="4s" repeatCount="indefinite" path="M6 150 C 80 150, 70 40, 150 40 S 240 110, 294 20"/></circle>
        </svg>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-wrap">
            <h2>Forgot password?</h2>
            <p>Enter your registered email — we'll send a reset request to your administrator.</p>

            <?php if (!empty($flash['error'])): ?>
            <div class="auth-alert error">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                <?= htmlspecialchars($flash['error']) ?>
            </div>
            <?php endif; ?>

            <form action="<?= $baseUrl ?>/forgot-password" method="POST" autocomplete="off">
                <div class="auth-field">
                    <label class="auth-label">Company email</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/></svg>
                        <input type="email" name="email" id="email" required placeholder="name@company.com">
                    </div>
                </div>

                <button type="submit" class="auth-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.24 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8 8.41a16 16 0 0 0 6 6l.87-.87a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    Submit reset request
                </button>
            </form>

            <a href="<?= $baseUrl ?>/login" class="back-link">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to sign in
            </a>
        </div>
    </div>
</div>

</body>
</html>
