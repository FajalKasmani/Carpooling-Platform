<?php
$title = "My Wallet";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon">
            <i class="bi bi-wallet2"></i>
        </span>
        My Wallet
    </div>
</div>

<div class="row g-4">
    <!-- Wallet Card + Recharge -->
    <div class="col-12 col-xl-5 reveal" style="animation-delay:.06s">
        <!-- Balance Card -->
        <div class="mb-4" style="background:linear-gradient(135deg,#6C63FF 0%,#9B8FFF 50%,#00D4AA 100%);border-radius:var(--radius-xl);padding:28px 28px 24px;position:relative;overflow:hidden;">
            <div style="position:absolute;top:-30%;right:-10%;width:200px;height:200px;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 70%);pointer-events:none;"></div>
            <div style="position:absolute;bottom:-20%;left:20%;width:150px;height:150px;background:radial-gradient(circle,rgba(0,0,0,0.08) 0%,transparent 70%);pointer-events:none;"></div>
            <div class="d-flex justify-content-between align-items-start mb-4" style="position:relative;z-index:1;">
                <div>
                    <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,0.65);display:block;margin-bottom:6px;">Total Prepaid Balance</span>
                    <h1 class="mono" style="font-size:36px;font-weight:700;color:#fff;margin:0;">₹<?= number_format($balance, 2) ?></h1>
                </div>
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff;">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
            <div style="border-top:1px solid rgba(255,255,255,0.2);padding-top:14px;position:relative;z-index:1;">
                <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,0.5);display:block;margin-bottom:4px;">MEMBER ACCOUNT</span>
                <span style="font-weight:600;color:#fff;font-size:14px;"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
            </div>
        </div>

        <!-- Recharge Form -->
        <div class="card p-4">
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:8px;display:flex;align-items:center;gap:8px;">
                <i class="bi bi-plus-circle-fill" style="color:var(--accent);"></i> Add Money to Wallet
            </h5>
            <p style="color:var(--text-muted);font-size:13px;margin-bottom:20px;line-height:1.6;">Instantly load funds to purchase seats on shared commutes. Settle via simulated checkout.</p>

            <form id="wallet-recharge-form" autocomplete="off">
                <div class="mb-4">
                    <label class="form-label">Amount to Add (₹)</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text" style="font-weight:700;">₹</span>
                        <input type="number" class="form-control" id="recharge-amount" min="10" max="10000" step="10" value="500" required>
                    </div>
                </div>

                <div class="row row-cols-3 g-2 mb-4">
                    <div class="col"><button type="button" class="btn btn-glass w-100 py-2 fw-semibold preset-amt" data-val="100" style="font-size:13px;">+ ₹100</button></div>
                    <div class="col"><button type="button" class="btn btn-primary w-100 py-2 fw-semibold preset-amt" data-val="500" style="font-size:13px;">+ ₹500</button></div>
                    <div class="col"><button type="button" class="btn btn-glass w-100 py-2 fw-semibold preset-amt" data-val="1000" style="font-size:13px;">+ ₹1000</button></div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="bi bi-credit-card"></i> Top Up Instantly
                </button>
            </form>
        </div>
    </div>

    <!-- Transaction Ledger -->
    <div class="col-12 col-xl-7 reveal" style="animation-delay:.1s">
        <div class="card p-4 h-100">
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
                <i class="bi bi-clock-history" style="color:var(--accent);"></i> Transaction Ledger
            </h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Reference / Description</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="wallet-history-tbody">
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div style="width:48px;height:48px;border-radius:14px;background:var(--bg-soft);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:22px;color:var(--text-faint);">
                                        <i class="bi bi-receipt-cutoff"></i>
                                    </div>
                                    <div style="color:var(--text-muted);font-size:13.5px;">No ledger entries yet.</div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $t): ?>
                                <tr>
                                    <td><small style="color:var(--text-muted);"><?= date('M d, Y h:i A', strtotime($t['created_at'])) ?></small></td>
                                    <td>
                                        <span style="font-weight:600;"><?= htmlspecialchars(str_replace('_', ' ', $t['reference'] ?? 'Wallet Update')) ?></span>
                                        <span class="badge ms-2 <?= $t['type'] === 'recharge' ? 'badge-green' : 'badge-red' ?>" style="font-size:9.5px;text-transform:uppercase;">
                                            <?= $t['type'] ?>
                                        </span>
                                    </td>
                                    <td class="text-end" style="font-weight:700;font-family:'JetBrains Mono',monospace;color:<?= $t['type'] === 'recharge' ? 'var(--green)' : 'var(--red)' ?>;">
                                        <?= $t['type'] === 'recharge' ? '+' : '-' ?> ₹<?= number_format($t['amount'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Preset values buttons
        document.querySelectorAll('.preset-amt').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('recharge-amount').value = btn.dataset.val;
            });
        });

        // Recharge handler
        document.getElementById('wallet-recharge-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const amount = parseFloat(document.getElementById('recharge-amount').value);

            const res = await fetchJSON('/wallet/recharge', {
                method: 'POST',
                body: JSON.stringify({ amount: amount, reference: 'wallet_topup' })
            });

            if (res.success) {
                showToast(res.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showToast(res.error, 'error');
            }
        });
    });
</script>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
