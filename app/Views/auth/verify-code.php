<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code — RideShare</title>
    <link rel="icon" type="image/svg+xml" href="<?= $baseUrl ?>/favicon.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
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
            <h2>Enter the Admin Verification Code.</h2>
            <p>Ask your administrator for the 4-digit code generated for your reset request. Enter it to proceed.</p>
            <div class="auth-points">
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div><div class="pt">One-time code</div><div class="ps">The code is valid for a single use and expires when used.</div></div>
                </div>
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div><div class="pt">Admin approval</div><div class="ps">Your administrator has reviewed and generated this code for you.</div></div>
                </div>
            </div>
        </div>
        <div class="auth-foot">&copy; <?= date('Y') ?> RideShare &middot; Built for secure corporate rides</div>
        <svg class="auth-route-svg" viewBox="0 0 300 170" fill="none">
            <path d="M6 150 C 80 150, 70 40, 150 40 S 240 110, 294 20" stroke="url(#vcGrad)" stroke-width="1.5" stroke-linecap="round"/>
            <defs><linearGradient id="vcGrad" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#6C63FF"/><stop offset="100%" stop-color="#00D4AA"/></linearGradient></defs>
            <circle r="4" fill="#6C63FF" opacity=".9"><animateMotion dur="4s" repeatCount="indefinite" path="M6 150 C 80 150, 70 40, 150 40 S 240 110, 294 20"/></circle>
        </svg>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-wrap">
            <h2>Enter code</h2>
            <p>A request has been registered for: <strong style="color:var(--text);"><?= htmlspecialchars($email) ?></strong>. Enter the 4-digit code provided by your administrator.</p>

            <?php if (!empty($flash['error'])): ?>
            <div class="auth-alert error">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                <?= htmlspecialchars($flash['error']) ?>
            </div>
            <?php endif; ?>

            <form action="<?= $baseUrl ?>/forgot-password/verify" method="POST" autocomplete="off">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">

                <div class="auth-field">
                    <label class="auth-label">4-digit code from admin</label>
                    <div class="input-wrap" style="justify-content:center;padding:16px 14px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <input type="text" name="code" id="code" required maxlength="4"
                               placeholder="0 0 0 0"
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                               style="font-family:'JetBrains Mono',monospace;font-size:26px;font-weight:600;letter-spacing:10px;text-align:center;width:100%;border:none;outline:none;background:transparent;color:var(--text);">
                    </div>
                </div>

                <button type="submit" class="auth-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Verify code
                </button>
            </form>

            <a href="<?= $baseUrl ?>/forgot-password" class="back-link">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to email entry
            </a>
        </div>
    </div>
</div>

</body>
</html>
