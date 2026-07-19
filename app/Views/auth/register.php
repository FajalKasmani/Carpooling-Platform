<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — RideShare</title>
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
            <h2>Start your smart commuting journey.</h2>
            <p>Register with your company email and join colleagues already sharing routes.</p>
            <div class="auth-points">
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div><div class="pt">Auto organization match</div><div class="ps">Your workplace is detected from your email domain.</div></div>
                </div>
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div><div class="pt">Personal wallet</div><div class="ps">Top up, pay, and receive seat payouts from one place.</div></div>
                </div>
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div><div class="pt">Drive or ride</div><div class="ps">Register a vehicle to offer rides, or search as a passenger.</div></div>
                </div>
            </div>
        </div>
        <div class="auth-foot">&copy; <?= date('Y') ?> RideShare &middot; Built for secure corporate rides</div>
        <svg class="auth-route-svg" viewBox="0 0 300 170" fill="none">
            <path d="M6 150 C 80 150, 70 40, 150 40 S 240 110, 294 20" stroke="url(#regGrad)" stroke-width="1.5" stroke-linecap="round"/>
            <defs><linearGradient id="regGrad" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#6C63FF"/><stop offset="100%" stop-color="#00D4AA"/></linearGradient></defs>
            <circle r="4" fill="#6C63FF" opacity=".9"><animateMotion dur="4s" repeatCount="indefinite" path="M6 150 C 80 150, 70 40, 150 40 S 240 110, 294 20"/></circle>
        </svg>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-wrap">
            <h2>Create your account</h2>
            <p>Takes about a minute — no company approval required.</p>

            <?php if (!empty($flash['error'])): ?>
            <div class="auth-alert error">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                <?= htmlspecialchars($flash['error']) ?>
            </div>
            <?php endif; ?>

            <form action="<?= $baseUrl ?>/register" method="POST" autocomplete="off">

                <div class="auth-field">
                    <label class="auth-label">Full name</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
                        <input type="text" name="name" id="name" required placeholder="Jane Doe">
                    </div>
                </div>

                <div class="auth-field">
                    <label class="auth-label">Company email</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/></svg>
                        <input type="email" name="email" id="email" required placeholder="name@company.com">
                    </div>
                    <div class="field-hint">Your organization is detected automatically from this domain.</div>
                </div>

                <div class="auth-field">
                    <label class="auth-label">Mobile number</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="6" y="2" width="12" height="20" rx="2"/><path d="M11 18h2"/></svg>
                        <input type="tel" name="phone" id="phone" required placeholder="10-digit number">
                    </div>
                </div>

                <div class="auth-field">
                    <label class="auth-label">Password</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></svg>
                        <input type="password" name="password" id="password" required minlength="8" placeholder="At least 8 characters">
                    </div>
                </div>

                <button type="submit" class="auth-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    Create account
                </button>
            </form>

            <div class="auth-foot-link">
                Already have an account? <a href="<?= $baseUrl ?>/login">Sign in</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
