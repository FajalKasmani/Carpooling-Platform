/* ============================================================
   UDAAN Carpooling Platform — Dashboard & Search Results Loader
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {
    // Current Time Clock widget
    const timeEl = document.getElementById('current-time');
    if (timeEl) {
        const updateTime = () => {
            const now = new Date();
            timeEl.innerHTML = `<i class="bi bi-clock me-1 text-primary"></i>${now.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric' })} | ${now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
        };
        updateTime();
        setInterval(updateTime, 60000);
    }

    // Auto-detect which page we are on and load data
    if (document.getElementById('dash-wallet-balance')) {
        loadDashboardStats();
    }
    
    if (document.getElementById('matching-rides-container')) {
        loadSearchResults();
    }
});

/**
 * Fetch and display Employee Dashboard metrics widgets.
 */
async function loadDashboardStats() {
    // 1. Fetch wallet & vehicles stats
    const walletRes = await fetchJSON('/api/wallet');
    if (walletRes.success) {
        document.getElementById('dash-wallet-balance').innerText = walletRes.balance.toFixed(2);
    }

    const vehicleRes = await fetchJSON('/api/vehicles');
    if (vehicleRes.success) {
        document.getElementById('dash-vehicles-count').innerText = vehicleRes.vehicles.length;
    }

    // 2. Fetch reports summary
    const reportRes = await fetchJSON('/reports/summary');
    if (reportRes.success) {
        document.getElementById('dash-co2-saved').innerText = reportRes.summary.co2_saved_kg;
        document.getElementById('dash-distance-km').innerText = reportRes.summary.total_distance_km;
    }

    // 3. Fetch active trips
    const tripsRes = await fetchJSON('/api/myTrips');
    const container = document.getElementById('upcoming-trip-card');
    
    if (tripsRes.success && tripsRes.trips.length > 0) {
        const trip = tripsRes.trips[0]; // load next immediate trip
        container.innerHTML = `
            <div class="p-3 border rounded-3 bg-light d-flex justify-content-between align-items-center flex-wrap g-3">
                <div class="d-flex align-items-center">
                    <div class="fs-1 text-primary me-3 bg-white border p-2 rounded-circle">🚗</div>
                    <div>
                        <span class="badge bg-primary text-uppercase mb-1" style="font-size: 0.65rem;">${trip.user_role}</span>
                        <h6 class="fw-bold mb-1">${trip.pickup_address} <i class="bi bi-arrow-right mx-1 text-muted"></i> ${trip.drop_address}</h6>
                        <small class="text-muted"><i class="bi bi-calendar-event me-1"></i>${trip.travel_date} at ${trip.travel_time.substring(0, 5)}</small>
                    </div>
                </div>
                <a href="${baseUrl}/trip/${trip.id}" class="btn btn-primary fw-bold px-4 rounded-3 shadow-sm py-2">
                    <i class="bi bi-compass me-1"></i>Track Now
                </a>
            </div>
        `;
    } else {
        container.innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="bi bi-calendar3 fs-2 mb-2 d-block text-secondary opacity-50"></i>
                No upcoming commutes scheduled.
            </div>
        `;
    }
}

/**
 * Parse URL params to fetch search results and draw matching cards.
 */
async function loadSearchResults() {
    const params = new URLSearchParams(window.location.search);
    
    // Set matching summary header text
    if (document.getElementById('header-pickup')) {
        document.getElementById('header-pickup').innerText = params.get('pickup_address') || 'Source';
        document.getElementById('header-drop').innerText = params.get('drop_address') || 'Destination';
        document.getElementById('header-date').innerText = params.get('travel_date') || 'Tomorrow';
        document.getElementById('header-seats').innerText = (params.get('seats') || '1') + ' Seat(s)';
    }
    
    const body = {
        pickup_lat: params.get('pickup_lat'),
        pickup_lng: params.get('pickup_lng'),
        drop_lat: params.get('drop_lat'),
        drop_lng: params.get('drop_lng'),
        travel_date: params.get('travel_date'),
        travel_time: params.get('travel_time') || '09:00',
        seats: parseInt(params.get('seats') || '1')
    };

    const res = await fetchJSON('/rides/search', {
        method: 'POST',
        body: JSON.stringify(body)
    });

    const container = document.getElementById('matching-rides-container');
    if (!res.success || res.rides.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-5 card border-0 shadow-sm rounded-4">
                <i class="bi bi-emoji-frown fs-1 mb-3 text-secondary"></i>
                <h5 class="fw-bold">No Matching Rides</h5>
                <p class="mb-0">Try modifying your search radius or preferred time settings.</p>
            </div>
        `;
        return;
    }

    container.innerHTML = '';
    res.rides.forEach(ride => {
        const card = document.createElement('div');
        card.className = 'card border-0 shadow-sm rounded-4 mb-3 overflow-hidden ride-card';
        card.innerHTML = `
            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="fs-2 bg-primary bg-opacity-10 p-2.5 rounded-circle me-3">🧑</div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">${ride.driver_name}</h6>
                                <div class="text-warning small">
                                    <i class="bi bi-star-fill"></i> ${ride.driver_rating || '4.5'}
                                </div>
                            </div>
                        </div>
                        <span class="badge bg-secondary rounded-pill px-2.5 py-1 text-uppercase" style="font-size: 0.7rem;">
                            ${ride.vehicle_model} (${ride.registration_number})
                        </span>
                    </div>
                    
                    <div class="col-12 col-md-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-clock-fill text-primary me-2"></i>
                            <span class="fw-bold text-dark">${ride.travel_time.substring(0, 5)}</span>
                        </div>
                        <div class="text-muted" style="font-size: 0.85rem;">
                            <i class="bi bi-people-fill me-1"></i> ${ride.available_seats} seats left of ${ride.total_seats}
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-3 text-md-end">
                        <span class="text-muted d-block" style="font-size: 0.75rem;">FARE PER SEAT</span>
                        <h3 class="fw-extrabold text-primary mb-3">₹${parseFloat(ride.fare_per_seat).toFixed(2)}</h3>
                        <button class="btn btn-primary w-100 fw-bold rounded-3 py-2 select-ride-btn" 
                                data-id="${ride.id}" 
                                data-driver="${ride.driver_name}" 
                                data-vehicle="${ride.vehicle_model} (${ride.registration_number})"
                                data-fare="${ride.fare_per_seat}">
                            Select Ride
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(card);
    });

    setupBookingTriggerActions();
}

/**
 * Configure checkout confirmation modal triggers.
 */
let selectedRideId = null;
let selectedFare = 0;

function setupBookingTriggerActions() {
    const modal = new bootstrap.Modal(document.getElementById('bookModal'));
    
    document.querySelectorAll('.select-ride-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            selectedRideId = btn.dataset.id;
            selectedFare = parseFloat(btn.dataset.fare);
            
            // Populate modal values
            document.getElementById('modal-driver-name').innerText = btn.dataset.driver;
            document.getElementById('modal-vehicle-info').innerText = btn.dataset.vehicle;
            document.getElementById('modal-fare-seat').innerText = selectedFare.toFixed(2);
            
            const params = new URLSearchParams(window.location.search);
            const seats = parseInt(params.get('seats') || '1');
            const totalFare = selectedFare * seats;
            
            document.getElementById('modal-seats-count').innerText = seats;
            document.getElementById('modal-total-fare').innerText = totalFare.toFixed(2);
            
            // Get wallet balance via api
            const res = await fetchJSON('/api/wallet');
            if (res.success) {
                document.getElementById('modal-wallet-balance').innerText = res.balance.toFixed(2);
                
                const warning = document.getElementById('modal-wallet-warning');
                const confirmBtn = document.getElementById('confirm-booking-btn');
                
                if (res.balance < totalFare) {
                    warning.classList.remove('d-none');
                    confirmBtn.disabled = true;
                } else {
                    warning.classList.add('d-none');
                    confirmBtn.disabled = false;
                }
            }
            
            modal.show();
        });
    });

    // Book click confirm action
    document.getElementById('confirm-booking-btn').addEventListener('click', async () => {
        const params = new URLSearchParams(window.location.search);
        const seats = parseInt(params.get('seats') || '1');
        
        const res = await fetchJSON('/bookRide', {
            method: 'POST',
            body: JSON.stringify({ ride_id: selectedRideId, seats: seats })
        });
        
        modal.hide();
        if (res.success) {
            showToast(res.message, 'success');
            setTimeout(() => {
                window.location.href = baseUrl + '/my-trips';
            }, 1200);
        } else {
            showToast(res.error, 'error');
        }
    });
}
