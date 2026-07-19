<?php
$title = "Settings";
require_once dirname(__DIR__) . '/layouts/header.php';
require_once dirname(__DIR__) . '/layouts/sidebar.php';
?>

<div class="page-header reveal">
    <div class="page-title">
        <span class="page-title-icon">
            <i class="bi bi-gear-fill"></i>
        </span>
        Settings
    </div>
</div>

<div class="row g-4">
    <!-- Left Column -->
    <div class="col-12 col-lg-5">
        <!-- Quick Navigation -->
        <div class="card p-4 mb-4 reveal" style="animation-delay:.06s">
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:15px;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                <i class="bi bi-lightning-charge-fill" style="color:var(--yellow);"></i> Quick Navigation
            </h5>
            <div class="d-grid gap-2">
                <a href="<?= $baseUrl ?>/my-trips" class="btn btn-glass d-flex align-items-center justify-content-between py-2 px-3">
                    <span><i class="bi bi-calendar-event me-2" style="color:var(--accent);"></i>My Trips</span>
                    <i class="bi bi-chevron-right" style="font-size:11px;color:var(--text-faint);"></i>
                </a>
                <a href="<?= $baseUrl ?>/vehicles" class="btn btn-glass d-flex align-items-center justify-content-between py-2 px-3">
                    <span><i class="bi bi-car-front me-2" style="color:var(--teal);"></i>My Vehicles</span>
                    <i class="bi bi-chevron-right" style="font-size:11px;color:var(--text-faint);"></i>
                </a>
                <a href="<?= $baseUrl ?>/wallet" class="btn btn-glass d-flex align-items-center justify-content-between py-2 px-3">
                    <span><i class="bi bi-wallet2 me-2" style="color:var(--yellow);"></i>Payment Methods / Wallet</span>
                    <i class="bi bi-chevron-right" style="font-size:11px;color:var(--text-faint);"></i>
                </a>
                <a href="<?= $baseUrl ?>/ride-history" class="btn btn-glass d-flex align-items-center justify-content-between py-2 px-3">
                    <span><i class="bi bi-clock-history me-2" style="color:var(--orange);"></i>Ride History</span>
                    <i class="bi bi-chevron-right" style="font-size:11px;color:var(--text-faint);"></i>
                </a>
            </div>
        </div>

        <!-- Help & Support -->
        <div class="card p-4 reveal" style="animation-delay:.09s">
            <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:15px;margin-bottom:12px;display:flex;align-items:center;gap:8px;">
                <i class="bi bi-question-circle-fill" style="color:var(--accent);"></i> Help & Support
            </h5>
            <p style="color:var(--text-muted);font-size:13px;margin-bottom:18px;line-height:1.65;">Need assistance? Browse common FAQs or get in touch with your organization's program administrator.</p>

            <div class="accordion accordion-flush" id="faqAccordion" style="border:1px solid var(--border);border-radius:var(--radius-md);overflow:hidden;">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" style="font-size:13px;font-weight:600;">
                            How are fares calculated?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="font-size:12.5px;color:var(--text-muted);">
                            Fares are computed based on the direct travel distance (km) multiplied by the organization's baseline rate (default ₹8/km), split across available passenger seats.
                        </div>
                    </div>
                </div>
                <div class="accordion-item" style="border-top:1px solid var(--border);">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" style="font-size:13px;font-weight:600;">
                            Who covers toll charges?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="font-size:12.5px;color:var(--text-muted);">
                            Tolls and parking expenses are split equally among all ongoing journey participants, settled directly outside wallet deductions.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Saved Places -->
    <div class="col-12 col-lg-7">
        <div class="card p-4 mb-4 reveal" style="animation-delay:.12s">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;margin:0;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-geo-alt-fill" style="color:var(--orange);"></i> Saved Places
                </h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPlaceModal">
                    <i class="bi bi-plus-circle"></i> Add Location
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Address</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($places)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div style="width:48px;height:48px;border-radius:14px;background:var(--bg-soft);display:flex;align-items:center;justify-content:center;font-size:22px;color:var(--text-faint);margin:0 auto 14px;">
                                        <i class="bi bi-geo"></i>
                                    </div>
                                    <div style="color:var(--text-muted);font-size:13.5px;">No saved places. Add Home or Office for faster routing.</div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($places as $p): ?>
                                <tr>
                                    <td>
                                        <span class="badge badge-accent text-capitalize"><?= htmlspecialchars($p['label']) ?></span>
                                    </td>
                                    <td style="color:var(--text);max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($p['address']) ?></td>
                                    <td class="text-end">
                                        <form action="<?= $baseUrl ?>/saved-places/<?= $p['id'] ?>/delete" method="POST" onsubmit="return confirm('Remove this saved place?');">
                                            <button type="submit" class="btn btn-danger btn-sm" style="width:36px;height:34px;padding:0;">
                                                <i class="bi bi-trash" style="font-size:12px;"></i>
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
<div class="modal fade" id="addPlaceModal" tabindex="-1" aria-labelledby="addPlaceModalLabel" aria-hidden="true" style="z-index:1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-modal">
            <div class="modal-header" style="background:linear-gradient(135deg,rgba(108,99,255,0.15),rgba(0,212,170,0.08));border-bottom:1px solid var(--border);">
                <h5 class="modal-title" id="addPlaceModalLabel" style="font-family:'Outfit',sans-serif;font-weight:700;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-plus-circle" style="color:var(--accent);"></i> Save New Location
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= $baseUrl ?>/saved-places" method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label for="label" class="form-label">Location Label</label>
                        <input type="text" class="form-control" id="label" name="label" required placeholder="e.g. Home, Office, Gym">
                    </div>

                    <div class="mb-4 position-relative">
                        <label for="address" class="form-label">Address Details</label>
                        <div class="input-group">
                            <span class="input-group-text" style="color:var(--accent);"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="address" name="address" required placeholder="Search neighborhood/address">
                        </div>
                        <input type="hidden" id="lat" name="lat">
                        <input type="hidden" id="lng" name="lng">
                        <div class="list-group position-absolute w-100 z-3 d-none mt-1" id="address-suggestions" style="max-height:200px;overflow-y:auto;border-radius:var(--radius-md);"></div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="bi bi-check-circle"></i> Save Location
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
