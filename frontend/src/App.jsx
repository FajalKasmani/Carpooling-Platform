import React, { useState, useEffect } from 'react';
import { api } from './api';
import { 
  Welcome, Login, Register, ForgotPassword, VerifyCode, 
  ResetPassword, Layout, Dashboard, FindRide, OfferRide, 
  MyTrips, WalletPanel, AdminEmployees, AdminVehicles, AdminSettings 
} from './components/Pages';

function App() {
  const [currentPath, setCurrentPath] = useState(window.location.hash.slice(1) || '/');
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  // Sync state with location hash
  useEffect(() => {
    const handleHashChange = () => {
      const path = window.location.hash.slice(1) || '/';
      setCurrentPath(path);
    };
    window.addEventListener('hashchange', handleHashChange);
    
    // Check initial authentication
    api.whoAmI()
      .then(res => {
        if (res.success && res.user) {
          setUser(res.user);
          // Redirect to appropriate dashboard if at welcome/auth page
          const path = window.location.hash.slice(1) || '/';
          if (path === '/' || path === '/login' || path === '/register') {
            const dest = res.user.role === 'admin' ? '/admin/dashboard' : '/dashboard';
            window.location.hash = dest;
          }
        }
        setLoading(false);
      })
      .catch(() => {
        // Not logged in
        setUser(null);
        setLoading(false);
      });

    return () => window.removeEventListener('hashchange', handleHashChange);
  }, []);

  const navigate = (path) => {
    window.location.hash = path;
    setCurrentPath(path);
  };

  const handleLoginSuccess = () => {
    setLoading(true);
    api.whoAmI()
      .then(res => {
        if (res.success && res.user) {
          setUser(res.user);
          const dest = res.user.role === 'admin' ? '/admin/dashboard' : '/dashboard';
          navigate(dest);
        }
        setLoading(false);
      })
      .catch(err => {
        console.error(err);
        setLoading(false);
      });
  };

  const handleLogout = async () => {
    try {
      await api.logout();
    } catch (e) {}
    setUser(null);
    navigate('/');
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-slate-50">
        <div className="flex flex-col items-center gap-3">
          <div className="w-12 h-12 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin" />
          <span className="text-slate-500 font-bold text-sm">Authenticating Odoo...</span>
        </div>
      </div>
    );
  }

  // Auth Guard
  const isAuthPage = ['/', '/login', '/register', '/forgot-password', '/forgot-password/verify', '/reset-password'].some(p => currentPath.startsWith(p));
  
  if (!user && !isAuthPage) {
    // Force redirect to welcome
    setTimeout(() => navigate('/'), 0);
    return null;
  }

  // Render Auth screens
  if (!user) {
    if (currentPath === '/') return <Welcome onNavigate={navigate} />;
    if (currentPath === '/login') return <Login onNavigate={navigate} onLoginSuccess={handleLoginSuccess} />;
    if (currentPath === '/register') return <Register onNavigate={navigate} onLoginSuccess={handleLoginSuccess} />;
    if (currentPath.startsWith('/forgot-password/verify')) return <VerifyCode onNavigate={navigate} />;
    if (currentPath.startsWith('/forgot-password')) return <ForgotPassword onNavigate={navigate} />;
    if (currentPath.startsWith('/reset-password')) return <ResetPassword onNavigate={navigate} />;
    
    // Default fallback
    return <Welcome onNavigate={navigate} />;
  }

  // Render Logged in workspace
  return (
    <Layout user={user} currentPath={currentPath} onNavigate={navigate} onLogout={handleLogout}>
      {/* Employee Pages */}
      {currentPath === '/dashboard' && <Dashboard user={user} onNavigate={navigate} />}
      {currentPath === '/find-ride' && <FindRide onNavigate={navigate} />}
      {currentPath === '/offer-ride' && <OfferRide onNavigate={navigate} />}
      {currentPath === '/my-trips' && <MyTrips />}
      {currentPath === '/wallet' && <WalletPanel />}

      {/* Admin Pages */}
      {currentPath === '/admin/dashboard' && <AdminEmployees onNavigate={navigate} />}
      {currentPath === '/admin/vehicles' && <AdminVehicles onNavigate={navigate} />}
      {currentPath === '/admin/settings' && <AdminSettings onNavigate={navigate} />}
    </Layout>
  );
}

export default App;
