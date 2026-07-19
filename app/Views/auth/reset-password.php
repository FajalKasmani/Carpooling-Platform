<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — RideShare</title>
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
            <h2>Set a new secure password.</h2>
            <p>You've been verified. Choose a strong new password to protect your corporate commuting account.</p>
            <div class="auth-points">
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div><div class="pt">Admin verified</div><div class="ps">Your identity was confirmed via the admin-issued code.</div></div>
                </div>
                <div class="auth-point">
                    <div class="auth-point-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    <div><div class="pt">Minimum 8 characters</div><div class="ps">Use a mix of letters, numbers, and symbols for a strong password.</div></div>
                </div>
            </div>
        </div>
        <div class="auth-foot">&copy; <?= date('Y') ?> RideShare &middot; Built for secure corporate rides</div>
        <svg class="auth-route-svg" viewBox="0 0 300 170" fill="none">
            <path d="M6 150 C 80 150, 70 40, 150 40 S 240 110, 294 20" stroke="url(#rpGrad)" stroke-width="1.5" stroke-linecap="round"/>
            <defs><linearGradient id="rpGrad" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#6C63FF"/><stop offset="100%" stop-color="#00D4AA"/></linearGradient></defs>
            <circle r="4" fill="#6C63FF" opacity=".9"><animateMotion dur="4s" repeatCount="indefinite" path="M6 150 C 80 150, 70 40, 150 40 S 240 110, 294 20"/></circle>
        </svg>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-wrap">
            <h2>Reset password</h2>
            <p>Setting new password for: <strong style="color:var(--text);"><?= htmlspecialchars($email) ?></strong></p>

            <?php if (!empty($flash['error'])): ?>
            <div class="auth-alert error">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                <?= htmlspecialchars($flash['error']) ?>
            </div>
            <?php endif; ?>

            <form action="<?= $baseUrl ?>/reset-password" method="POST" autocomplete="off" onsubmit="return validatePasswords();">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                <input type="hidden" name="code" value="<?= htmlspecialchars($code) ?>">

                <div class="auth-field">
                    <label class="auth-label">New password</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></svg>
                        <input type="password" name="password" id="password" required minlength="8" placeholder="At least 8 characters">
                    </div>
                </div>

                <div class="auth-field">
                    <label class="auth-label">Confirm new password</label>
                    <div class="input-wrap" id="confirm-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></svg>
                        <input type="password" id="confirm_password" required minlength="8" placeholder="Repeat new password">
                    </div>
                    <div id="passwordError" style="font-size:11.5px;color:#EF4444;margin-top:7px;display:none;">Passwords do not match.</div>
                </div>

                <button type="submit" class="auth-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Update password
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function validatePasswords() {
        const p = document.getElementById('password').value;
        const c = document.getElementById('confirm_password').value;
        const err = document.getElementById('passwordError');
        const wrap = document.getElementById('confirm-wrap');
        if (p !== c) {
            err.style.display = 'block';
            wrap.style.borderColor = '#EF4444';
            return false;
        }
        err.style.display = 'none';
        return true;
    }
</script>

</body>
</html>
