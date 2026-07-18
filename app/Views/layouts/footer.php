        </div>
    </div>

    <!-- Mobile Bottom Navigation Bar -->
    <nav class="navbar navbar-dark bg-dark fixed-bottom d-lg-none border-top border-secondary py-1" id="mobile-bottom-nav">
        <div class="container-fluid d-flex justify-content-around">
            <a href="<?= $baseUrl ?>/dashboard" class="text-center text-decoration-none text-light opacity-75 nav-btn-active" id="mobile-nav-home">
                <div class="fs-4"><i class="bi bi-house-door"></i></div>
                <small style="font-size: 0.65rem;">Home</small>
            </a>
            <a href="<?= $baseUrl ?>/find-ride" class="text-center text-decoration-none text-light opacity-75" id="mobile-nav-find">
                <div class="fs-4"><i class="bi bi-search"></i></div>
                <small style="font-size: 0.65rem;">Find</small>
            </a>
            <a href="<?= $baseUrl ?>/offer-ride" class="text-center text-decoration-none text-light opacity-75" id="mobile-nav-offer">
                <div class="fs-4"><i class="bi bi-plus-circle"></i></div>
                <small style="font-size: 0.65rem;">Offer</small>
            </a>
            <a href="<?= $baseUrl ?>/my-trips" class="text-center text-decoration-none text-light opacity-75" id="mobile-nav-trips">
                <div class="fs-4"><i class="bi bi-calendar-event"></i></div>
                <small style="font-size: 0.65rem;">Trips</small>
            </a>
            <a href="<?= $baseUrl ?>/wallet" class="text-center text-decoration-none text-light opacity-75" id="mobile-nav-wallet">
                <div class="fs-4"><i class="bi bi-wallet2"></i></div>
                <small style="font-size: 0.65rem;">Wallet</small>
            </a>
        </div>
    </nav>

    <!-- Global Toast Notification Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
        <div id="appToast" class="toast align-items-center text-white border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <i id="toastIcon" class="bi me-2 fs-5"></i>
                    <span id="toastMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Leaflet JS (Map) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Global Helper Script Variables -->
    <script>
        const baseUrl = '<?= $baseUrl ?>';
        const userId = '<?= $_SESSION['user_id'] ?? '' ?>';
    </script>
    
    <!-- Application Scripts -->
    <script src="<?= $baseUrl ?>/assets/js/app.js"></script>
    
    <!-- Page Specific Notifications -->
    <?php
    $sessionFlash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    if ($sessionFlash):
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast('<?= $sessionFlash["message"] ?>', '<?= $sessionFlash["type"] ?>');
        });
    </script>
    <?php endif; ?>
</body>
</html>
