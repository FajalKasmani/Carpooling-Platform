const BASE_URL = '/CarPooling/public';

async function request(endpoint, options = {}) {
  const url = `${BASE_URL}${endpoint}`;
  
  // Setup headers
  options.headers = {
    'Content-Type': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    ...options.headers
  };

  // Stringify body if it's an object and not FormData
  if (options.body && typeof options.body === 'object' && !(options.body instanceof FormData)) {
    options.body = JSON.stringify(options.body);
  }

  // Include credentials for session cookie sharing
  options.credentials = 'include';

  try {
    const res = await fetch(url, options);
    
    // Check for redirects (our PHP controllers redirect for Auth transitions)
    if (res.redirected) {
      // Return a special payload so our React router can navigate
      const path = res.url.replace(window.location.origin + BASE_URL, '');
      return { redirected: true, path };
    }

    if (!res.ok) {
      let errData = {};
      try {
        errData = await res.json();
      } catch (e) {}
      throw new Error(errData.error || `HTTP error ${res.status}`);
    }

    // Try parsing JSON, fallback to text
    const contentType = res.headers.get('content-type');
    if (contentType && contentType.includes('application/json')) {
      return await res.json();
    }
    return await res.text();
  } catch (error) {
    console.error(`API Error on ${endpoint}:`, error);
    throw error;
  }
}

export const api = {
  // Auth
  login: (email, password) => request('/login', {
    method: 'POST',
    // Using URLencoded parameters since AuthController expects standard form fields
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ email, password }).toString()
  }),
  
  register: (data) => request('/register', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams(data).toString()
  }),
  
  logout: () => request('/logout'),
  whoAmI: () => request('/api/whoami'),

  // Password Recovery
  forgotPassword: (email) => request('/forgot-password', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ email }).toString()
  }),

  verifyCode: (email, code) => request('/forgot-password/verify', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ email, code }).toString()
  }),

  resetPassword: (email, code, password) => request('/reset-password', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ email, code, password }).toString()
  }),

  // Rides & Bookings
  searchRides: (searchData) => request('/rides/search', {
    method: 'POST',
    body: searchData
  }),

  offerRide: (rideData) => request('/offerRide', {
    method: 'POST',
    body: rideData
  }),

  bookRide: (bookingData) => request('/bookRide', {
    method: 'POST',
    body: bookingData
  }),

  // Trips
  getMyTrips: () => request('/api/myTrips'),
  getTripDetails: (id) => request(`/trip/${id}`),
  startTrip: (id) => request(`/trip/${id}/start`, { method: 'POST' }),
  endTrip: (id) => request(`/trip/${id}/end`, { method: 'POST' }),
  sendGPSLocation: (id, lat, lng, eta) => request(`/trip/${id}/location`, {
    method: 'POST',
    body: { current_lat: lat, current_lng: lng, eta_minutes: eta }
  }),
  getGPSLocation: (id) => request(`/trip/${id}/location`),

  // Wallet
  getWallet: () => request('/api/wallet'),
  rechargeWallet: (amount, reference) => request('/wallet/recharge', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ amount, reference }).toString()
  }),

  // Admin
  getAdminStats: () => request('/admin/dashboard'), // returns view HTML or json depending on headers
  getAdminEmployees: () => request('/admin/employees'),
  toggleEmployeeAccess: (userId, newStatus) => request(`/admin/employees/${userId}`, {
    method: 'POST',
    body: { status: newStatus }
  }),
  getAdminVehicles: () => request('/admin/vehicles'),
  getAdminSettings: () => request('/admin/settings'),
  saveAdminSettings: (data) => request('/admin/settings', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams(data).toString()
  })
};
