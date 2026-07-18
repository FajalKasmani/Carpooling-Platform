/* ============================================================
   UDAAN Carpooling Platform — core javascript helpers
   ============================================================ */

/**
 * Perform a fetch request returning JSON, handling base url.
 */
async function fetchJSON(url, options = {}) {
    const fullUrl = baseUrl + url;
    
    // Add default headers for JSON calls
    options.headers = {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        ...(options.headers || {})
    };
    
    try {
        const response = await fetch(fullUrl, options);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Fetch error:', error);
        return { success: false, error: 'Request failed. Please try again.' };
    }
}

/**
 * Display premium Toast Notification.
 * @param {string} message Toast notification message
 * @param {string} type success, error, info, warning
 */
function showToast(message, type = 'info') {
    const toastEl = document.getElementById('appToast');
    const toastMessage = document.getElementById('toastMessage');
    const toastIcon = document.getElementById('toastIcon');
    
    if (!toastEl) return;
    
    // Set message
    toastMessage.textContent = message;
    
    // Reset classes
    toastEl.className = 'toast align-items-center text-white border-0 shadow';
    toastIcon.className = 'bi me-2 fs-5';
    
    // Configure based on type
    switch (type) {
        case 'success':
            toastEl.classList.add('bg-success');
            toastIcon.classList.add('bi-check-circle-fill');
            break;
        case 'error':
            toastEl.classList.add('bg-danger');
            toastIcon.classList.add('bi-exclamation-triangle-fill');
            break;
        case 'warning':
            toastEl.classList.add('bg-warning', 'text-dark');
            toastIcon.classList.add('bi-exclamation-circle-fill');
            break;
        case 'info':
        default:
            toastEl.classList.add('bg-info');
            toastIcon.classList.add('bi-info-circle-fill');
            break;
    }
    
    const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
    toast.show();
}

/**
 * Handle autocomplete address fields using OpenStreetMap Nominatim.
 */
function setupAddressAutocomplete(inputId, suggestionsId, onSelectCallback) {
    const input = document.getElementById(inputId);
    const suggestions = document.getElementById(suggestionsId);
    
    if (!input || !suggestions) return;
    
    let timeout = null;
    
    input.addEventListener('input', () => {
        clearTimeout(timeout);
        const query = input.value.trim();
        
        if (query.length < 3) {
            suggestions.classList.add('d-none');
            return;
        }
        
        timeout = setTimeout(async () => {
            const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=5&countrycodes=in`;
            try {
                const res = await fetch(url, { headers: { 'User-Agent': 'UDAAN-App' } });
                const data = await res.json();
                
                suggestions.innerHTML = '';
                if (data.length === 0) {
                    suggestions.classList.add('d-none');
                    return;
                }
                
                suggestions.classList.remove('d-none');
                suggestions.classList.add('list-group', 'suggestions-list');
                
                data.forEach(item => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'list-group-item list-group-item-action text-start text-truncate';
                    btn.style.fontSize = '0.85rem';
                    btn.innerHTML = `<i class="bi bi-geo-alt-fill text-muted me-2"></i>${item.display_name}`;
                    
                    btn.addEventListener('click', () => {
                        input.value = item.display_name;
                        suggestions.classList.add('d-none');
                        onSelectCallback({
                            address: item.display_name,
                            lat: parseFloat(item.lat),
                            lng: parseFloat(item.lon)
                        });
                    });
                    suggestions.appendChild(btn);
                });
            } catch (err) {
                console.error(err);
            }
        }, 500);
    });
    
    // Hide suggestions on outside click
    document.addEventListener('click', (e) => {
        if (e.target !== input && e.target !== suggestions) {
            suggestions.classList.add('d-none');
        }
    });
}
