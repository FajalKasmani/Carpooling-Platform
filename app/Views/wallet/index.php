<?php
$title = "My Wallet";
require_once dirname(__DIR__) . '/layouts/header.php';
//require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-wallet2 me-2 text-primary"></i>My Wallet</h1>
</div>

<div class="row g-4">
    <!-- Wallet Card Widget & Recharge Form -->
    <div class="col-12 col-xl-5">
        <!-- Balance Card -->
        <div class="card border-0 text-white shadow-lg rounded-4 mb-4 p-4" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <span class="text-white-50 d-block text-uppercase fw-bold" style="font-size: 0.8rem; letter-spacing: 0.05em;">Total Prepaid Balance</span>
                    <h1 class="fw-extrabold text-white mt-1 mb-0">₹<?= number_format($balance, 2) ?></h1>
                </div>
                <div class="fs-1 text-white-50"><i class="bi bi-wallet2"></i></div>
            </div>
            
            <div class="border-top border-white-50 border-opacity-10 pt-3">
                <span class="text-white-50 d-block mb-1" style="font-size: 0.75rem;">MEMBER ACCOUNT</span>
                <span class="fw-medium text-white"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
            </div>
        </div>

        <!-- Recharge Form -->
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-plus-circle-fill text-primary me-2"></i>Add Money to Wallet</h5>
            <p class="text-muted" style="font-size: 0.85rem;">Instantly load funds to purchase seats on shared commutes. Settle via simulated checkout.</p>
            
            <form id="wallet-recharge-form" autocomplete="off">
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted">Amount to Add (₹)</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-transparent border-secondary fw-bold text-muted">₹</span>
                        <input type="number" class="form-control" id="recharge-amount" min="10" max="10000" step="10" value="500" required>
                    </div>
                </div>

                <div class="row row-cols-3 g-2 mb-4">
                    <div class="col">
                        <button type="button" class="btn btn-outline-secondary w-100 py-2.5 rounded-3 fw-semibold preset-amt" data-val="100">+ ₹100</button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-outline-secondary w-100 py-2.5 rounded-3 fw-semibold preset-amt animate" data-val="500">+ ₹500</button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-outline-secondary w-100 py-2.5 rounded-3 fw-semibold preset-amt" data-val="1000">+ ₹1000</button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-3 shadow-sm py-2.5">
                    <i class="bi bi-credit-card me-2"></i>Top Up Instantly
                </button>
            </form>
        </div>
    </div>

    <!-- Transaction Ledger -->
    <div class="col-12 col-xl-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-clock-history text-primary me-2"></i>Transaction Ledger</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 rounded-start">Date</th>
                            <th class="border-0">Reference / Description</th>
                            <th class="border-0 text-end rounded-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="wallet-history-tbody">
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-5">
                                    <i class="bi bi-receipt-cutoff fs-2 mb-2 d-block text-secondary opacity-50"></i>
                                    No ledger entries yet.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $t): ?>
                                <tr>
                                    <td>
                                        <small class="text-muted"><?= date('M d, Y h:i A', strtotime($t['created_at'])) ?></small>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark"><?= htmlspecialchars(str_replace('_', ' ', $t['reference'] ?? 'Wallet Update')) ?></span>
                                        <span class="badge rounded-pill ms-2 text-uppercase bg-<?= $t['type'] === 'recharge' ? 'success' : 'danger' ?> bg-opacity-10 text-<?= $t['type'] === 'recharge' ? 'success' : 'danger' ?>" style="font-size: 0.65rem;">
                                            <?= $t['type'] ?>
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold text-<?= $t['type'] === 'recharge' ? 'success' : 'danger' ?>">
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
