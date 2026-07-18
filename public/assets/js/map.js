/* ============================================================
   UDAAN Carpooling Platform — Maps, Routes and GPS tracking
   ============================================================ */

let map = null;
let routeControl = null;
let driverMarker = null;
let pickupMarker = null;
let dropMarker = null;

/**
 * Initialize Find Ride search map.
 */
function initSearchMap() {
    const mapContainer = document.getElementById('live-map');
    if (!mapContainer) return;
    
    // Default focus on Ahmedabad/Gandhinagar coordinates
    map = L.map('live-map').setView([23.0225, 72.5714], 11);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    setupAddressAutocomplete('pickup_address', 'pickup-suggestions', (data) => {
        document.getElementById('pickup_lat').value = data.lat;
        document.getElementById('pickup_lng').value = data.lng;
        updateSearchMarkers();
    });
    
    setupAddressAutocomplete('drop_address', 'drop-suggestions', (data) => {
        document.getElementById('drop_lat').value = data.lat;
        document.getElementById('drop_lng').value = data.lng;
        updateSearchMarkers();
    });

    // Form search rides submit action
    const searchForm = document.getElementById('search-ride-form');
    if (searchForm) {
        searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const date = document.getElementById('travel_date').value;
            const time = document.getElementById('travel_time').value;
            const seats = document.getElementById('seats').value;
            const pickupLat = document.getElementById('pickup_lat').value;
            const pickupLng = document.getElementById('pickup_lng').value;
            const dropLat = document.getElementById('drop_lat').value;
            const dropLng = document.getElementById('drop_lng').value;
            
            const params = new URLSearchParams({
                pickup_address: document.getElementById('pickup_address').value,
                drop_address: document.getElementById('drop_address').value,
                travel_date: date,
                travel_time: time,
                seats: seats,
                pickup_lat: pickupLat,
                pickup_lng: pickupLng,
                drop_lat: dropLat,
                drop_lng: dropLng
            });
            window.location.href = baseUrl + '/rides/available?' + params.toString();
        });
    }
}

function updateSearchMarkers() {
    const plat = parseFloat(document.getElementById('pickup_lat').value);
    const plng = parseFloat(document.getElementById('pickup_lng').value);
    const dlat = parseFloat(document.getElementById('drop_lat').value);
    const dlng = parseFloat(document.getElementById('drop_lng').value);
    
    if (plat && plng) {
        if (pickupMarker) map.removeLayer(pickupMarker);
        pickupMarker = L.marker([plat, plng], { title: 'Pickup' }).addTo(map).bindPopup('<b>Starting neighborhood</b>').openPopup();
        map.setView([plat, plng], 13);
    }
    
    if (dlat && dlng) {
        if (dropMarker) map.removeLayer(dropMarker);
        dropMarker = L.marker([dlat, dlng], { title: 'Destination' }).addTo(map).bindPopup('<b>Office Campus</b>');
    }
    
    if (plat && plng && dlat && dlng) {
        // Draw the actual route polyline
        calculateRoute();
    }
}

/**
 * Initialize Offer Ride map with routing options.
 */
function initOfferMap() {
    const mapContainer = document.getElementById('live-map');
    if (!mapContainer) return;
    
    map = L.map('live-map').setView([23.0225, 72.5714], 11);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    setupAddressAutocomplete('pickup_address', 'pickup-suggestions', (data) => {
        document.getElementById('pickup_lat').value = data.lat;
        document.getElementById('pickup_lng').value = data.lng;
        calculateRoute();
    });
    
    setupAddressAutocomplete('drop_address', 'drop-suggestions', (data) => {
        document.getElementById('drop_lat').value = data.lat;
        document.getElementById('drop_lng').value = data.lng;
        calculateRoute();
    });

    const offerForm = document.getElementById('offer-ride-form');
    if (offerForm) {
        offerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const body = {
                vehicle_id: document.getElementById('vehicle_id').value,
                pickup_address: document.getElementById('pickup_address').value,
                pickup_lat: document.getElementById('pickup_lat').value,
                pickup_lng: document.getElementById('pickup_lng').value,
                drop_address: document.getElementById('drop_address').value,
                drop_lat: document.getElementById('drop_lat').value,
                drop_lng: document.getElementById('drop_lng').value,
                travel_date: document.getElementById('travel_date').value,
                travel_time: document.getElementById('travel_time').value,
                available_seats: document.getElementById('available_seats').value,
                fare_per_seat: document.getElementById('fare_per_seat').value,
                distance_km: document.getElementById('distance_km').value,
                route_polyline: document.getElementById('route_polyline').value,
                is_recurring: document.getElementById('is_recurring').checked ? 1 : 0
            };

            const res = await fetchJSON('/offerRide', {
                method: 'POST',
                body: JSON.stringify(body)
            });

            if (res.success) {
                showToast(res.message, 'success');
                setTimeout(() => {
                    window.location.href = baseUrl + '/my-trips';
                }, 1000);
            } else {
                showToast(res.error, 'error');
            }
        });
    }
}

async function calculateRoute() {
    const plat = document.getElementById('pickup_lat').value;
    const plng = document.getElementById('pickup_lng').value;
    const dlat = document.getElementById('drop_lat').value;
    const dlng = document.getElementById('drop_lng').value;
    
    if (!plat || !plng || !dlat || !dlng) return;
    
    const publishBtn = document.getElementById('publish-btn');
    if (publishBtn) publishBtn.disabled = true;
    
    // Query OSRM router
    const url = `https://router.project-osrm.org/route/v1/driving/${plng},${plat};${dlng},${dlat}?overview=full&geometries=polyline`;
    try {
        const res = await fetch(url);
        const data = await res.json();
        
        if (data.routes && data.routes.length > 0) {
            const route = data.routes[0];
            const distance = (route.distance / 1000).toFixed(1); // km
            
            if (document.getElementById('distance_km')) {
                document.getElementById('distance_km').value = distance;
            }
            if (document.getElementById('route_polyline')) {
                document.getElementById('route_polyline').value = route.geometry;
            }
            
            // Set mileage suggest fare
            if (document.getElementById('fare_per_seat')) {
                const defaultFareRate = 8.0;
                const suggestedFare = Math.round(distance * defaultFareRate);
                document.getElementById('fare_per_seat').value = suggestedFare;
                if (document.getElementById('suggested-fare-tip')) {
                    document.getElementById('suggested-fare-tip').innerText = `Recommended fare based on ₹8/km route default.`;
                }
            }
            
            // Draw Route Line
            drawPolyline(route.geometry);
            
            if (publishBtn) publishBtn.disabled = false;
        }
    } catch (err) {
        console.error(err);
    }
}

function drawPolyline(encodedString) {
    if (routeControl) map.removeLayer(routeControl);
    
    // Custom polyline decode
    const points = decodePolyline(encodedString);
    routeControl = L.polyline(points, { color: '#6366f1', weight: 5 }).addTo(map);
    
    // Fit bounds
    map.fitBounds(routeControl.getBounds(), { padding: [40, 40] });
    
    // Add markers
    if (pickupMarker) map.removeLayer(pickupMarker);
    if (dropMarker) map.removeLayer(dropMarker);
    
    pickupMarker = L.marker(points[0]).addTo(map).bindPopup('Pickup');
    dropMarker = L.marker(points[points.length - 1]).addTo(map).bindPopup('Destination');
}

function decodePolyline(encoded) {
    let points = [];
    let index = 0, len = encoded.length;
    let lat = 0, lng = 0;
    
    while (index < len) {
        let b, shift = 0, result = 0;
        do {
            b = encoded.charCodeAt(index++) - 63;
            result |= (b & 0x1f) << shift;
            shift += 5;
        } while (b >= 0x20);
        let dlat = ((result & 1) ? ~(result >> 1) : (result >> 1));
        lat += dlat;
        
        shift = 0;
        result = 0;
        do {
            b = encoded.charCodeAt(index++) - 63;
            result |= (b & 0x1f) << shift;
            shift += 5;
        } while (b >= 0x20);
        let dlng = ((result & 1) ? ~(result >> 1) : (result >> 1));
        lng += dlng;
        
        points.push([lat * 1e-5, lng * 1e-5]);
    }
    return points;
}

/**
 * Initialize Trip Live Tracking map screen.
 */
function initTrackingMap() {
    const mapContainer = document.getElementById('live-map');
    if (!mapContainer) return;
    
    map = L.map('live-map').setView([pickupLat, pickupLng], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    if (routePolyline) {
        drawPolyline(routePolyline);
    } else {
        pickupMarker = L.marker([pickupLat, pickupLng]).addTo(map).bindPopup('Pickup');
        dropMarker = L.marker([dropLat, dropLng]).addTo(map).bindPopup('Destination');
        map.fitBounds([[pickupLat, pickupLng], [dropLat, dropLng]]);
    }
    
    // Add custom styled driver marker
    const driverIcon = L.divIcon({
        className: 'custom-driver-icon',
        html: '<div style="background-color: #0ea5e9; border: 3px solid white; width: 20px; height: 20px; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.35);"></div>',
        iconSize: [20, 20]
    });
    
    driverMarker = L.marker([pickupLat, pickupLng], { icon: driverIcon }).addTo(map).bindPopup('<b>Driver current location</b>');

    // Run active tracking loops
    if (isDriver) {
        startDriverLocationBroadcaster();
    } else {
        startPassengerLocationPoller();
    }
    
    setupTripActionButtons();
    startChatPoller();
}

/**
 * Driver GPS broadcast logic.
 */
let broadcastInterval = null;
function startDriverLocationBroadcaster() {
    if (navigator.geolocation) {
        // Watch driver geolocations
        navigator.geolocation.getCurrentPosition(position => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            sendDriverLocation(lat, lng);
        });

        broadcastInterval = setInterval(() => {
            navigator.geolocation.getCurrentPosition(position => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                sendDriverLocation(lat, lng);
            }, err => console.log(err), { enableHighAccuracy: true });
        }, 8000);
    } else {
        // Fallback: simulate movement along line
        simulateDriverMovement();
    }
}

async function sendDriverLocation(lat, lng) {
    if (driverMarker) driverMarker.setLatLng([lat, lng]);
    await fetchJSON(`/trip/${bookingId}/location`, {
        method: 'POST',
        body: JSON.stringify({ lat: lat, lng: lng, eta: 10 })
    });
}

function simulateDriverMovement() {
    const points = routePolyline ? decodePolyline(routePolyline) : [[pickupLat, pickupLng], [dropLat, dropLng]];
    let step = 0;
    
    broadcastInterval = setInterval(() => {
        if (step >= points.length) {
            clearInterval(broadcastInterval);
            return;
        }
        const currentPt = points[step];
        sendDriverLocation(currentPt[0], currentPt[1]);
        step += Math.max(1, Math.floor(points.length / 20)); // simulated 20 steps
    }, 5000);
}

/**
 * Passenger polling tracking loops.
 */
function startPassengerLocationPoller() {
    setInterval(async () => {
        const res = await fetchJSON(`/trip/${bookingId}/location`);
        if (res.success && res.location) {
            const lat = parseFloat(res.location.current_lat);
            const lng = parseFloat(res.location.current_lng);
            if (driverMarker) driverMarker.setLatLng([lat, lng]);
            
            // Check if status completed, reload to trigger payment views
            if (res.status === 'trip_completed' && document.getElementById('trip-status-badge').innerText.toLowerCase() !== 'trip completed') {
                window.location.reload();
            }
        }
    }, 6000);
}

/**
 * Driver Trip lifecycle controllers triggers.
 */
function setupTripActionButtons() {
    const startBtn = document.getElementById('btn-start-trip');
    const endBtn = document.getElementById('btn-end-trip');
    const payWalletBtn = document.getElementById('btn-pay-wallet');
    const payCashBtn = document.getElementById('btn-pay-cash');
    
    if (startBtn) {
        startBtn.addEventListener('click', async () => {
            const res = await fetchJSON(`/trip/${bookingId}/start`, { method: 'POST' });
            if (res.success) {
                showToast(res.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showToast(res.error, 'error');
            }
        });
    }
    
    if (endBtn) {
        endBtn.addEventListener('click', async () => {
            const res = await fetchJSON(`/trip/${bookingId}/end`, { method: 'POST' });
            if (res.success) {
                showToast(res.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showToast(res.error, 'error');
            }
        });
    }

    if (payWalletBtn) {
        payWalletBtn.addEventListener('click', async () => {
            const res = await fetchJSON('/payments/initiate', {
                method: 'POST',
                body: JSON.stringify({ booking_id: bookingId, method: 'wallet' })
            });
            if (res.success) {
                showToast('Prepaid payment success!', 'success');
                setTimeout(() => window.location.href = baseUrl + '/my-trips', 1200);
            } else {
                showToast(res.error, 'error');
            }
        });
    }

    if (payCashBtn) {
        payCashBtn.addEventListener('click', async () => {
            const res = await fetchJSON('/payments/initiate', {
                method: 'POST',
                body: JSON.stringify({ booking_id: bookingId, method: 'cash' })
            });
            if (res.success) {
                showToast('Cash billing initiated.', 'info');
                setTimeout(() => window.location.href = baseUrl + '/my-trips', 1200);
            }
        });
    }
}

/**
 * Ride chat group mock polling engine (session stored logs).
 */
const mockMessages = [
    { sender: "System", text: "Welcome to UDAAN ride chat!", time: "Now" }
];

function startChatPoller() {
    const chatContainer = document.getElementById('chat-messages');
    const emptyMsg = document.getElementById('chat-empty');
    
    renderChatMessages();

    document.getElementById('chat-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const text = input.value.trim();
        if (!text) return;
        
        mockMessages.push({
            sender: isDriver ? "Driver (You)" : "Passenger (You)",
            text: text,
            time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        });
        
        input.value = '';
        renderChatMessages();
    });
}

function renderChatMessages() {
    const chatContainer = document.getElementById('chat-messages');
    const emptyMsg = document.getElementById('chat-empty');
    
    if (mockMessages.length > 0 && emptyMsg) {
        emptyMsg.classList.add('d-none');
    }
    
    chatContainer.innerHTML = '';
    mockMessages.forEach(msg => {
        const div = document.createElement('div');
        const isSystem = msg.sender === 'System';
        
        div.className = `d-flex flex-column mb-3 ${isSystem ? 'align-items-center' : 'align-items-start'}`;
        if (msg.sender.includes('(You)')) div.className = 'd-flex flex-column mb-3 align-items-end';
        
        let bubbleClass = 'bg-white text-dark border';
        if (isSystem) bubbleClass = 'bg-secondary bg-opacity-10 text-muted';
        else if (msg.sender.includes('(You)')) bubbleClass = 'bg-primary text-white';
        
        div.innerHTML = `
            ${isSystem ? '' : `<small class="text-muted mb-1 fw-semibold" style="font-size:0.75rem;">${msg.sender}</small>`}
            <div class="px-3 py-2 rounded-3" style="max-width: 80%; word-break: break-word; font-size: 0.875rem; border-radius: 12px; ${isSystem ? 'text-center' : ''}" class="${bubbleClass}">
                ${msg.text}
            </div>
            ${isSystem ? '' : `<small class="text-muted mt-1" style="font-size:0.65rem;">${msg.time}</small>`}
        `;
        
        // Quick workaround for classes
        const innerDiv = div.querySelector('div');
        innerDiv.className = `px-3 py-2 ${bubbleClass}`;
        
        chatContainer.appendChild(div);
    });
    
    chatContainer.scrollTop = chatContainer.scrollHeight;
}
