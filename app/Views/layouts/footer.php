        </main>
        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="navbar fixed-bottom d-lg-none" id="mobile-bottom-nav" style="padding: 0.3rem 0;">
        <div class="container-fluid d-flex justify-content-around">
            <a href="<?= $baseUrl ?>/dashboard" class="text-center text-decoration-none opacity-60 nav-btn-active d-flex flex-column align-items-center px-2" id="mobile-nav-home" style="color:var(--text-muted);">
                <i class="bi bi-house-door fs-5"></i>
                <small style="font-size: 0.62rem; margin-top:2px;">Home</small>
            </a>
            <a href="<?= $baseUrl ?>/find-ride" class="text-center text-decoration-none d-flex flex-column align-items-center px-2" id="mobile-nav-find" style="color:var(--text-muted);">
                <i class="bi bi-search fs-5"></i>
                <small style="font-size: 0.62rem; margin-top:2px;">Find</small>
            </a>
            <a href="<?= $baseUrl ?>/offer-ride" class="text-center text-decoration-none d-flex flex-column align-items-center px-2" id="mobile-nav-offer" style="color:var(--text-muted);">
                <i class="bi bi-plus-circle fs-5"></i>
                <small style="font-size: 0.62rem; margin-top:2px;">Offer</small>
            </a>
            <a href="<?= $baseUrl ?>/my-trips" class="text-center text-decoration-none d-flex flex-column align-items-center px-2" id="mobile-nav-trips" style="color:var(--text-muted);">
                <i class="bi bi-calendar-event fs-5"></i>
                <small style="font-size: 0.62rem; margin-top:2px;">Trips</small>
            </a>
            <a href="<?= $baseUrl ?>/wallet" class="text-center text-decoration-none d-flex flex-column align-items-center px-2" id="mobile-nav-wallet" style="color:var(--text-muted);">
                <i class="bi bi-wallet2 fs-5"></i>
                <small style="font-size: 0.62rem; margin-top:2px;">Wallet</small>
            </a>
        </div>
    </nav>

    <!-- Toast Notification Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1200;">
        <div id="appToast" class="toast align-items-center border-0 shadow-modal" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i id="toastIcon" class="bi fs-5"></i>
                    <span id="toastMessage"></span>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Global JS Variables -->
    <script>
        const baseUrl = '<?= $baseUrl ?>';
        const userId  = '<?= $_SESSION['user_id'] ?? '' ?>';
    </script>

    <!-- Application Scripts -->
    <script src="<?= $baseUrl ?>/assets/js/app.js"></script>
    <!-- Page Animation Layer -->
    <script src="<?= $baseUrl ?>/assets/js/animations.js"></script>

    <!-- Flash Notification -->
    <?php
    $sessionFlash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    if ($sessionFlash):
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast('<?= addslashes($sessionFlash["message"]) ?>', '<?= $sessionFlash["type"] ?>');
        });
    </script>
    <?php endif; ?>
</body>
</html>
