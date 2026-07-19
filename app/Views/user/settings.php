<?php
$title = "Settings";
require_once dirname(__DIR__) . '/layouts/header.php';
//require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 fw-bold"><i class="bi bi-gear-fill me-2 text-primary"></i>Settings</h1>
</div>

<div class="row g-4">
    <!-- Left Column: Settings Options Shortcuts & Help Support -->
    <div class="col-12 col-lg-5">
        <!-- Quick Options Links -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Quick Navigation</h5>
            <div class="d-grid gap-2">
                <a href="<?= $baseUrl ?>/my-trips" class="btn btn-outline-secondary d-flex align-items-center justify-content-between py-2 px-3 rounded-3 text-dark text-start">
                    <span><i class="bi bi-calendar-event me-2 text-primary"></i>My Trips</span>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
                <a href="<?= $baseUrl ?>/vehicles" class="btn btn-outline-secondary d-flex align-items-center justify-content-between py-2 px-3 rounded-3 text-dark text-start">
                    <span><i class="bi bi-car-front me-2 text-success"></i>My Vehicles</span>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
                <a href="<?= $baseUrl ?>/wallet" class="btn btn-outline-secondary d-flex align-items-center justify-content-between py-2 px-3 rounded-3 text-dark text-start">
                    <span><i class="bi bi-wallet2 me-2 text-info"></i>Payment Methods / Wallet</span>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
                <a href="<?= $baseUrl ?>/ride-history" class="btn btn-outline-secondary d-flex align-items-center justify-content-between py-2 px-3 rounded-3 text-dark text-start">
                    <span><i class="bi bi-clock-history me-2 text-warning"></i>Ride History</span>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
            </div>
        </div>

        <!-- Help & Support -->
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-question-circle-fill text-info me-2"></i>Help & Support</h5>
            <p class="text-muted" style="font-size: 0.85rem;">Need assistance? Browse common FAQs or get in touch with your organization's program administrator.</p>
            
            <div class="accordion accordion-flush border rounded-3 overflow-hidden" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold text-dark" style="font-size: 0.85rem;" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            How are fares calculated?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted" style="font-size: 0.8rem;">
                            Fares are computed based on the direct travel distance (km) multiplied by the organization's baseline rate (default ₹8/km), split across available passenger seats.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold text-dark" style="font-size: 0.85rem;" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Who covers toll charges?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted" style="font-size: 0.8rem;">
                            Tolls and parking expenses are split equally among all ongoing journey participants, settled directly outside wallet deductions.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Saved Places Manager -->
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Saved Places</h5>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#addPlaceModal">
                    <i class="bi bi-plus-circle me-1"></i>Add Location
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle border-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 rounded-start">Label</th>
                            <th class="border-0">Address</th>
                            <th class="border-0 text-end rounded-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($places)): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-5">
                                    <i class="bi bi-geo fs-2 mb-2 d-block text-secondary opacity-50"></i>
                                    No saved places. Add Home or Office for faster routing.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($places as $p): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle rounded-pill px-3 py-1.5 fw-semibold text-capitalize">
                                            <?= htmlspecialchars($p['label']) ?>
                                        </span>
                                    </td>
                                    <td class="text-dark fw-medium text-truncate" style="max-width: 250px;"><?= htmlspecialchars($p['address']) ?></td>
                                    <td class="text-end">
                                        <form action="<?= $baseUrl ?>/saved-places/<?= $p['id'] ?>/delete" method="POST" onsubmit="return confirm('Remove this saved place?');">
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-3">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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

<!-- Add Place Modal -->
<div class="modal fade" id="addPlaceModal" tabindex="-1" aria-labelledby="addPlaceModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-modal">
            <div class="modal-header border-0 bg-primary text-white py-3">
                <h5 class="modal-title fw-bold" id="addPlaceModalLabel"><i class="bi bi-plus-circle me-2"></i>Save New Location</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= $baseUrl ?>/saved-places" method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label for="label" class="form-label fw-semibold text-muted">Location Label</label>
                        <input type="text" class="form-control py-2.5 rounded-3" id="label" name="label" required placeholder="e.g. Home, Office, Gym">
                    </div>
                    
                    <div class="mb-4 position-relative">
                        <label for="address" class="form-label fw-semibold text-muted">Address Details</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent text-primary border-secondary"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control border-start-0" id="address" name="address" required placeholder="Search neighborhood/address">
                        </div>
                        <input type="hidden" id="lat" name="lat">
                        <input type="hidden" id="lng" name="lng">
                        <div class="list-group position-absolute w-100 shadow-sm z-3 d-none mt-1" id="address-suggestions" style="max-height: 200px; overflow-y: auto;"></div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-3 py-2.5 shadow-sm">
                        <i class="bi bi-check-circle me-2"></i>Save Location
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        setupAddressAutocomplete('address', 'address-suggestions', (data) => {
            document.getElementById('lat').value = data.lat;
            document.getElementById('lng').value = data.lng;
        });
    });
</script>

<?php
require_once dirname(__DIR__) . '/layouts/footer.php';
?>
