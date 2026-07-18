import React, { useState, useEffect, useRef } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
  Car, Shield, Wallet, Landmark, User, Plus, Search, Calendar, 
  MapPin, Clock, ArrowRight, UserCheck, CheckCircle2, AlertCircle, 
  FileText, ShieldCheck, ArrowLeft, LogOut, Settings, Award, Users, 
  Sparkles, RefreshCw, Star, MessageCircle, Send, Check, X
} from 'lucide-react';
import { api } from '../api';

// ============================================================================
// PAGE: Welcome Landing Page (3D Animated)
// ============================================================================
export function Welcome({ onNavigate }) {
  return (
    <div className="min-vh-100 flex flex-col justify-between bg-slate-50 text-slate-800 relative overflow-hidden font-sans">
      {/* Background blobs */}
      <div className="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] rounded-full bg-radial-gradient bg-indigo-500/10 blur-3xl animate-float -z-10" />
      <div className="absolute bottom-[10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-radial-gradient bg-purple-500/10 blur-3xl animate-float -z-10" style={{ animationDelay: '2s' }} />

      {/* Header */}
      <nav className="container mx-auto px-6 py-6 flex justify-between items-center z-10">
        <div className="flex items-center gap-2 text-2xl font-extrabold text-indigo-600">
          <Car className="w-8 h-8 text-indigo-600" />
          <span>Odoo</span>
        </div>
        <div className="flex items-center gap-4">
          <button onClick={() => onNavigate('/login')} className="font-semibold text-slate-600 hover:text-indigo-600 transition-colors">
            Sign In
          </button>
          <button onClick={() => onNavigate('/register')} className="bg-indigo-600 text-white font-semibold px-5 py-2.5 rounded-full hover:bg-indigo-700 transition-all shadow-lg hover:shadow-indigo-500/20 active:scale-95">
            Register
          </button>
        </div>
      </nav>

      {/* Hero */}
      <main className="container mx-auto px-6 py-12 my-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center z-10">
        <motion.div 
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="text-center lg:text-start"
        >
          <div className="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm border border-slate-100 mb-6 animate-bounce">
            <span className="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-bold">New</span>
            <span className="text-slate-500 font-semibold text-xs">Safe corporate commutes for verified coworkers.</span>
          </div>

          <h1 className="text-4xl md:text-6xl font-extrabold text-slate-900 leading-none mb-6">
            Commute Better <br />
            With <span className="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Colleagues</span>
          </h1>

          <p className="text-slate-600 text-lg md:text-xl mb-8 pr-0 lg:pr-12">
            Odoo's enterprise carpooling platform connects you with verified coworkers heading the same way. Save fuel costs, reduce carbon emissions, and build a stronger company culture.
          </p>

          <div className="flex flex-wrap gap-4 justify-center lg:justify-start">
            <button onClick={() => onNavigate('/register')} className="bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold px-8 py-3.5 rounded-full shadow-xl hover:shadow-indigo-500/25 active:scale-98 transition-all">
              Start Sharing Rides
            </button>
            <a href="#features" className="bg-white border text-slate-700 font-semibold px-6 py-3.5 rounded-full shadow-sm hover:bg-slate-50 transition-colors flex items-center gap-2">
              Explore Features <ArrowRight className="w-4 h-4" />
            </a>
          </div>
        </motion.div>

        {/* 3D Glass Card */}
        <motion.div 
          initial={{ opacity: 0, scale: 0.9 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 0.8, delay: 0.2 }}
          className="perspective-1000"
        >
          <div className="glass-panel card-3d bg-white/80 border border-white/50 rounded-3xl p-8 md:p-10 shadow-2xl hover:shadow-indigo-500/10 transition-all transform-style-3d hover:translate-y-[-5px]">
            <div className="w-16 h-16 bg-indigo-500 rounded-2xl flex items-center justify-content-center text-white text-3xl shadow-lg shadow-indigo-500/30 mx-auto mb-6">
              <MapPin className="w-8 h-8 m-auto text-white" />
            </div>
            <h3 className="text-2xl font-bold text-slate-900 mb-2 text-center">Live Route Matching</h3>
            <p className="text-slate-500 text-center mb-8 max-w-sm mx-auto">Our intelligent algorithm calculates optimized routes and matches you instantly with coworkers living nearby.</p>
            
            <div className="flex justify-around pt-6 border-t border-slate-100">
              <div className="text-center">
                <div className="text-2xl font-extrabold text-slate-900">1.2M</div>
                <div className="text-xs font-semibold text-slate-400 uppercase tracking-wider">KM Saved</div>
              </div>
              <div className="text-center">
                <div className="text-2xl font-extrabold text-slate-900">50K+</div>
                <div className="text-xs font-semibold text-slate-400 uppercase tracking-wider">Rides Shared</div>
              </div>
            </div>
          </div>
        </motion.div>
      </main>

      {/* Features Section */}
      <section className="bg-white/60 border-t border-slate-100 py-16" id="features">
        <div className="container mx-auto px-6">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-2">Designed for the <span className="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Ecosystem</span></h2>
            <p className="text-slate-500">Discover highly detailed modular tools optimized specifically for daily corporate routines.</p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div className="feature-card bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm hover:border-indigo-500/50 hover:shadow-lg transition-all hover:-translate-y-1">
              <div className="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                <Search className="w-6 h-6" />
              </div>
              <h4 className="text-xl font-bold mb-2 text-slate-900">Find a Ride Instantly</h4>
              <p className="text-slate-500 text-sm">Search corporate commutes matching your schedule. View live seats, driver verification, and book instantly with your coworker wallet.</p>
            </div>

            <div className="feature-card bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm hover:border-indigo-500/50 hover:shadow-lg transition-all hover:-translate-y-1">
              <div className="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-4">
                <Plus className="w-6 h-6" />
              </div>
              <h4 className="text-xl font-bold mb-2 text-slate-900">Offer Routes & Save</h4>
              <p className="text-slate-500 text-sm">Publish routes with your registered vehicle, set custom seat fares, and save money. Fares are calculated automatically using organization settings.</p>
            </div>

            <div className="feature-card bg-white p-6 rounded-2xl border border-slate-200/60 shadow-sm hover:border-indigo-500/50 hover:shadow-lg transition-all hover:-translate-y-1">
              <div className="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
                <ShieldCheck className="w-6 h-6" />
              </div>
              <h4 className="text-xl font-bold mb-2 text-slate-900">Live GPS & Wallet</h4>
              <p className="text-muted text-sm">Real-time coordinates mapping, route directions, ETAs, and interactive group chats built directly into the app.</p>
            </div>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-white border-t border-slate-100 py-8 mt-auto">
        <div className="container mx-auto px-6 text-center">
          <p className="text-slate-500 font-semibold text-sm">
            &copy; {new Date().getFullYear()} Odoo. Built with ❤️ | <span className="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent font-bold">Odoo x KSV Hackathon</span>
          </p>
        </div>
      </footer>
    </div>
  );
}

// ============================================================================
// COMPONENT: SPLIT-SCREEN AUTH CONTAINER (Shared CSS layout)
// ============================================================================
function AuthLayout({ title, subtitle, rightTitle, rightSubtitle, children, onNavigate, error, success }) {
  return (
    <div className="min-h-screen flex flex-col lg:flex-row bg-slate-50 font-sans">
      {/* Left Column (Details) */}
      <div className="lg:w-1/2 bg-gradient-to-br from-indigo-600 to-purple-600 text-white p-12 lg:p-20 flex flex-col justify-between relative overflow-hidden">
        <div className="absolute top-[-100px] left-[-100px] w-[500px] h-[500px] rounded-full bg-white/5 blur-3xl pointer-events-none" />
        
        <div onClick={() => onNavigate('/')} className="flex items-center gap-2 text-2xl font-extrabold cursor-pointer z-10">
          <Car className="w-8 h-8" />
          <span>Odoo</span>
        </div>

        <div className="my-auto max-w-md z-10 py-12 lg:py-0">
          <div className="inline-flex items-center gap-2 bg-white/10 border border-white/20 px-4 py-1.5 rounded-full text-xs font-semibold mb-6">
            <Shield className="w-4 h-4" />
            <span>Safe Corporate Commutes</span>
          </div>
          <h1 className="text-3xl lg:text-5xl font-extrabold mb-4 leading-tight">
            {title}
          </h1>
          <p className="text-white/95 text-lg mb-8">
            {subtitle}
          </p>

          <div className="flex flex-col gap-5">
            <div className="flex items-start gap-4">
              <div className="bg-white/20 p-2.5 rounded-xl"><UserCheck className="w-5 h-5" /></div>
              <div>
                <h5 className="font-bold mb-1">Verify Coworkers</h5>
                <p className="text-sm text-white/80">Only employees within your enterprise domain can join.</p>
              </div>
            </div>
            <div className="flex items-start gap-4">
              <div className="bg-white/20 p-2.5 rounded-xl"><Wallet className="w-5 h-5" /></div>
              <div>
                <h5 className="font-bold mb-1">Fare Splits</h5>
                <p className="text-sm text-white/80">Recharge and transfer carpooling payments instantly via wallets.</p>
              </div>
            </div>
          </div>
        </div>

        <div className="z-10 text-white/80 text-sm">
          &copy; {new Date().getFullYear()} Odoo. Built for secure corporate rides.
        </div>
      </div>

      {/* Right Column (Form fields) */}
      <div className="lg:w-1/2 flex items-center justify-center p-8 lg:p-20 bg-white">
        <div className="w-full max-w-md">
          {/* Logo on Mobile only */}
          <div onClick={() => onNavigate('/')} className="flex items-center gap-2 text-2xl font-extrabold text-indigo-600 mb-8 lg:hidden cursor-pointer">
            <Car className="w-8 h-8" />
            <span>Odoo</span>
          </div>

          <div className="mb-6">
            <h2 className="text-2xl font-extrabold text-slate-900">{rightTitle}</h2>
            <p className="text-slate-500 text-sm">{rightSubtitle}</p>
          </div>

          {error && (
            <div className="alert bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex items-start gap-3">
              <AlertCircle className="w-5 h-5 flex-shrink-0 mt-0.5" />
              <span className="font-semibold text-sm">{error}</span>
            </div>
          )}

          {success && (
            <div className="alert bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 flex flex-col gap-2">
              <div className="flex items-center gap-2">
                <CheckCircle2 className="w-5 h-5 flex-shrink-0" />
                <span className="font-bold text-sm">Success!</span>
              </div>
              <div className="text-xs" dangerouslySetInnerHTML={{ __html: success }} />
            </div>
          )}

          {children}
        </div>
      </div>
    </div>
  );
}

// ============================================================================
// PAGE: Login Page
// ============================================================================
export function Login({ onNavigate, onLoginSuccess }) {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    try {
      const res = await api.login(email, password);
      if (res.redirected) {
        onLoginSuccess();
      } else {
        setError('Login failed. Please check credentials.');
      }
    } catch (err) {
      setError(err.message || 'Invalid email or password.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <AuthLayout
      title="Connect with your coworkers, share the ride."
      subtitle="Odoo's dedicated carpooling platform helps you find convenient daily travel routes with employees in your company."
      rightTitle="Welcome back"
      rightSubtitle="Enter your enterprise email to access your account"
      onNavigate={onNavigate}
      error={error}
    >
      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Corporate Email</label>
          <div className="flex rounded-xl border border-slate-200 overflow-hidden focus-within:border-indigo-600 focus-within:ring-4 focus-within:ring-indigo-100 transition-all bg-slate-50">
            <span className="px-4 bg-slate-50 text-slate-400 flex items-center border-r border-slate-100"><User className="w-4 h-4" /></span>
            <input 
              type="email" 
              required 
              value={email}
              onChange={e => setEmail(e.target.value)}
              placeholder="name@company.com" 
              className="w-full px-4 py-3 bg-transparent border-0 outline-none text-slate-800"
            />
          </div>
        </div>

        <div>
          <div className="flex justify-between items-center mb-2">
            <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider">Password</label>
            <button type="button" onClick={() => onNavigate('/forgot-password')} className="text-xs font-bold text-indigo-600 hover:text-indigo-700">Forgot password?</button>
          </div>
          <div className="flex rounded-xl border border-slate-200 overflow-hidden focus-within:border-indigo-600 focus-within:ring-4 focus-within:ring-indigo-100 transition-all bg-slate-50">
            <span className="px-4 bg-slate-50 text-slate-400 flex items-center border-r border-slate-100"><Shield className="w-4 h-4" /></span>
            <input 
              type="password" 
              required 
              value={password}
              onChange={e => setPassword(e.target.value)}
              placeholder="••••••••" 
              className="w-full px-4 py-3 bg-transparent border-0 outline-none text-slate-800"
            />
          </div>
        </div>

        <button 
          type="submit" 
          disabled={loading}
          className="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 active:scale-[0.98] transition-all disabled:opacity-50 mt-6"
        >
          {loading ? 'Signing In...' : 'Sign In'}
        </button>
      </form>

      <div className="text-center mt-6 text-sm text-slate-500">
        New to the platform?{' '}
        <button onClick={() => onNavigate('/register')} className="text-indigo-600 font-bold hover:underline">Register Account</button>
      </div>
    </AuthLayout>
  );
}

// ============================================================================
// PAGE: Register Page
// ============================================================================
export function Register({ onNavigate, onLoginSuccess }) {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    try {
      const res = await api.register({ name, email, phone, password });
      if (res.redirected) {
        onLoginSuccess();
      } else {
        setError('Registration failed. Try checking your organization email domain.');
      }
    } catch (err) {
      setError(err.message || 'Registration failed.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <AuthLayout
      title="Start your smart commuting journey today."
      subtitle="Register your official company email and join thousands of corporate colleagues sharing routes."
      rightTitle="Create Account"
      rightSubtitle="Create your corporate commuter account in seconds"
      onNavigate={onNavigate}
      error={error}
    >
      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Full Name</label>
          <div className="flex rounded-xl border border-slate-200 overflow-hidden focus-within:border-indigo-600 focus-within:ring-4 focus-within:ring-indigo-100 transition-all bg-slate-50">
            <span className="px-4 bg-slate-50 text-slate-400 flex items-center border-r border-slate-100"><User className="w-4 h-4" /></span>
            <input 
              type="text" 
              required 
              value={name}
              onChange={e => setName(e.target.value)}
              placeholder="John Doe" 
              className="w-full px-4 py-3 bg-transparent border-0 outline-none text-slate-800"
            />
          </div>
        </div>

        <div>
          <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Corporate Email</label>
          <div className="flex rounded-xl border border-slate-200 overflow-hidden focus-within:border-indigo-600 focus-within:ring-4 focus-within:ring-indigo-100 transition-all bg-slate-50">
            <span className="px-4 bg-slate-50 text-slate-400 flex items-center border-r border-slate-100"><User className="w-4 h-4" /></span>
            <input 
              type="email" 
              required 
              value={email}
              onChange={e => setEmail(e.target.value)}
              placeholder="name@company.com" 
              className="w-full px-4 py-3 bg-transparent border-0 outline-none text-slate-800"
            />
          </div>
          <div className="text-slate-400 text-[10px] mt-1 font-semibold">Your organization will be auto-detected via email domain.</div>
        </div>

        <div>
          <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Mobile Number</label>
          <div className="flex rounded-xl border border-slate-200 overflow-hidden focus-within:border-indigo-600 focus-within:ring-4 focus-within:ring-indigo-100 transition-all bg-slate-50">
            <span className="px-4 bg-slate-50 text-slate-400 flex items-center border-r border-slate-100"><Clock className="w-4 h-4" /></span>
            <input 
              type="tel" 
              required 
              value={phone}
              onChange={e => setPhone(e.target.value)}
              placeholder="9876543210" 
              className="w-full px-4 py-3 bg-transparent border-0 outline-none text-slate-800"
            />
          </div>
        </div>

        <div>
          <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
          <div className="flex rounded-xl border border-slate-200 overflow-hidden focus-within:border-indigo-600 focus-within:ring-4 focus-within:ring-indigo-100 transition-all bg-slate-50">
            <span className="px-4 bg-slate-50 text-slate-400 flex items-center border-r border-slate-100"><Shield className="w-4 h-4" /></span>
            <input 
              type="password" 
              required 
              value={password}
              onChange={e => setPassword(e.target.value)}
              placeholder="At least 8 characters" 
              className="w-full px-4 py-3 bg-transparent border-0 outline-none text-slate-800"
            />
          </div>
        </div>

        <button 
          type="submit" 
          disabled={loading}
          className="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 active:scale-[0.98] transition-all disabled:opacity-50 mt-6"
        >
          {loading ? 'Creating Account...' : 'Create Account'}
        </button>
      </form>

      <div className="text-center mt-6 text-sm text-slate-500">
        Already have an account?{' '}
        <button onClick={() => onNavigate('/login')} className="text-indigo-600 font-bold hover:underline">Sign In</button>
      </div>
    </AuthLayout>
  );
}

// ============================================================================
// PAGE: Forgot Password
// ============================================================================
export function ForgotPassword({ onNavigate }) {
  const [email, setEmail] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');
    setSuccess('');

    try {
      await api.forgotPassword(email);
      // Our PHP AuthController redirects directly to /forgot-password/verify?email=EMAIL
      onNavigate(`/forgot-password/verify?email=${encodeURIComponent(email)}`);
    } catch (err) {
      setError(err.message || 'No account found with that email.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <AuthLayout
      title="Request password reset from Admin."
      subtitle="Input your official registered email address. This will send a reset request directly to the administrator dashboard."
      rightTitle="Forgot Password?"
      rightSubtitle="Enter your registered email below to send a request to your administrator."
      onNavigate={onNavigate}
      error={error}
      success={success}
    >
      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Corporate Email</label>
          <div className="flex rounded-xl border border-slate-200 overflow-hidden focus-within:border-indigo-600 focus-within:ring-4 focus-within:ring-indigo-100 transition-all bg-slate-50">
            <span className="px-4 bg-slate-50 text-slate-400 flex items-center border-r border-slate-100"><User className="w-4 h-4" /></span>
            <input 
              type="email" 
              required 
              value={email}
              onChange={e => setEmail(e.target.value)}
              placeholder="name@company.com" 
              className="w-full px-4 py-3 bg-transparent border-0 outline-none text-slate-800"
            />
          </div>
        </div>

        <button 
          type="submit" 
          disabled={loading}
          className="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 active:scale-[0.98] transition-all disabled:opacity-50 mt-6"
        >
          {loading ? 'Submitting...' : 'Submit Reset Request'}
        </button>
      </form>

      <div className="text-center mt-6">
        <button onClick={() => onNavigate('/login')} className="text-indigo-600 font-bold hover:underline text-sm flex items-center gap-2 mx-auto"><ArrowLeft className="w-4 h-4" /> Back to Sign In</button>
      </div>
    </AuthLayout>
  );
}

// ============================================================================
// PAGE: Verify Reset Code
// ============================================================================
export function VerifyCode({ onNavigate }) {
  const params = new URLSearchParams(window.location.hash.split('?')[1] || '');
  const email = params.get('email') || '';
  const [code, setCode] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    try {
      await api.verifyCode(email, code);
      // AuthController redirects to /reset-password?email=EMAIL&code=CODE
      onNavigate(`/reset-password?email=${encodeURIComponent(email)}&code=${encodeURIComponent(code)}`);
    } catch (err) {
      setError(err.message || 'Incorrect or expired code.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <AuthLayout
      title="Admin Approval Required"
      subtitle="Ask your administrator for the 4-digit code generated for your reset request. Enter it on the right to reset your password."
      rightTitle="Enter Code"
      rightSubtitle={`Enter the 4-digit code provided by your administrator for: ${email}`}
      onNavigate={onNavigate}
      error={error}
    >
      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">4-Digit Verification Code</label>
          <div className="flex rounded-xl border border-slate-200 overflow-hidden focus-within:border-indigo-600 focus-within:ring-4 focus-within:ring-indigo-100 transition-all bg-slate-50">
            <span className="px-4 bg-slate-50 text-slate-400 flex items-center border-r border-slate-100"><ShieldCheck className="w-4 h-4" /></span>
            <input 
              type="text" 
              required 
              maxLength="4"
              value={code}
              onChange={e => setCode(e.target.value)}
              placeholder="0000" 
              className="w-full px-4 py-3 bg-transparent border-0 outline-none text-slate-800 text-center font-bold text-xl tracking-widest"
            />
          </div>
        </div>

        <button 
          type="submit" 
          disabled={loading}
          className="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 active:scale-[0.98] transition-all disabled:opacity-50 mt-6"
        >
          {loading ? 'Verifying...' : 'Verify Code'}
        </button>
      </form>

      <div className="text-center mt-6">
        <button onClick={() => onNavigate('/forgot-password')} className="text-indigo-600 font-bold hover:underline text-sm flex items-center gap-2 mx-auto"><ArrowLeft className="w-4 h-4" /> Back to Email Entry</button>
      </div>
    </AuthLayout>
  );
}

// ============================================================================
// PAGE: Reset Password Form
// ============================================================================
export function ResetPassword({ onNavigate }) {
  const params = new URLSearchParams(window.location.hash.split('?')[1] || '');
  const email = params.get('email') || '';
  const code = params.get('code') || '';
  
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (password !== confirmPassword) {
      setError('Passwords do not match.');
      return;
    }
    setLoading(true);
    setError('');

    try {
      await api.resetPassword(email, code, password);
      onNavigate('/login');
    } catch (err) {
      setError(err.message || 'Failed to update password.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <AuthLayout
      title="Create a secure new password."
      subtitle="Set up a strong password containing at least 8 characters to access your Odoo corporate carpool dashboard."
      rightTitle="Reset Password"
      rightSubtitle={`Setting new password for employee: ${email}`}
      onNavigate={onNavigate}
      error={error}
    >
      <form onSubmit={handleSubmit} className="space-y-4">
        <div>
          <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">New Password</label>
          <div className="flex rounded-xl border border-slate-200 overflow-hidden focus-within:border-indigo-600 focus-within:ring-4 focus-within:ring-indigo-100 transition-all bg-slate-50">
            <span className="px-4 bg-slate-50 text-slate-400 flex items-center border-r border-slate-100"><Shield className="w-4 h-4" /></span>
            <input 
              type="password" 
              required 
              value={password}
              onChange={e => setPassword(e.target.value)}
              placeholder="New password" 
              className="w-full px-4 py-3 bg-transparent border-0 outline-none text-slate-800"
            />
          </div>
        </div>

        <div>
          <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Confirm New Password</label>
          <div className="flex rounded-xl border border-slate-200 overflow-hidden focus-within:border-indigo-600 focus-within:ring-4 focus-within:ring-indigo-100 transition-all bg-slate-50">
            <span className="px-4 bg-slate-50 text-slate-400 flex items-center border-r border-slate-100"><ShieldCheck className="w-4 h-4" /></span>
            <input 
              type="password" 
              required 
              value={confirmPassword}
              onChange={e => setConfirmPassword(e.target.value)}
              placeholder="Repeat password" 
              className="w-full px-4 py-3 bg-transparent border-0 outline-none text-slate-800"
            />
          </div>
        </div>

        <button 
          type="submit" 
          disabled={loading}
          className="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 active:scale-[0.98] transition-all disabled:opacity-50 mt-6"
        >
          {loading ? 'Updating...' : 'Update Password'}
        </button>
      </form>
    </AuthLayout>
  );
}

// ============================================================================
// COMPONENT: LOGGED IN INTERFACE SHELL (Sidebar & Header)
// ============================================================================
export function Layout({ user, currentPath, onNavigate, onLogout, children }) {
  const [mobileOpen, setMobileOpen] = useState(false);
  const isAdmin = user?.role === 'admin';

  const menuItems = isAdmin ? [
    { label: 'Employees', icon: Users, path: '/admin/dashboard' },
    { label: 'Vehicles', icon: Car, path: '/admin/vehicles' },
    { label: 'Settings', icon: Settings, path: '/admin/settings' },
  ] : [
    { label: 'Dashboard', icon: Landmark, path: '/dashboard' },
    { label: 'Find a Ride', icon: Search, path: '/find-ride' },
    { label: 'Offer a Ride', icon: Plus, path: '/offer-ride' },
    { label: 'My Trips', icon: Calendar, path: '/my-trips' },
    { label: 'Wallet', icon: Wallet, path: '/wallet' },
  ];

  return (
    <div className="min-h-screen flex bg-slate-50 text-slate-800 font-sans">
      {/* Sidebar - Desktop */}
      <aside className="hidden lg:flex flex-col w-64 bg-slate-900 text-white shrink-0 shadow-xl border-r border-slate-800">
        <div className="p-6 border-b border-slate-800 flex items-center gap-2 text-xl font-bold text-indigo-400">
          <Car className="w-6 h-6" />
          <span>Odoo Carpool</span>
        </div>

        <nav className="flex-1 p-4 space-y-1">
          {menuItems.map((item, idx) => {
            const Icon = item.icon;
            const active = currentPath === item.path;
            return (
              <button
                key={idx}
                onClick={() => onNavigate(item.path)}
                className={`w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all text-left ${
                  active 
                    ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' 
                    : 'text-slate-400 hover:bg-slate-800 hover:text-white'
                }`}
              >
                <Icon className="w-5 h-5" />
                <span>{item.label}</span>
              </button>
            );
          })}
        </nav>

        <div className="p-4 border-t border-slate-800">
          <button 
            onClick={onLogout}
            className="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm text-red-400 hover:bg-red-500/10 hover:text-white transition-all text-left"
          >
            <LogOut className="w-5 h-5" />
            <span>Sign Out</span>
          </button>
        </div>
      </aside>

      {/* Main Content Area */}
      <div className="flex-1 flex flex-col min-w-0">
        {/* Top Header */}
        <header className="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center shadow-sm">
          <div className="flex items-center gap-3">
            <button 
              onClick={() => setMobileOpen(!mobileOpen)}
              className="lg:hidden text-slate-500 hover:text-slate-700 focus:outline-none"
            >
              <Users className="w-6 h-6" />
            </button>
            <h2 className="text-xl font-bold text-slate-800">
              {isAdmin ? 'Admin Portal' : `${user?.org_name || 'Organization'}`}
            </h2>
          </div>

          <div className="flex items-center gap-4">
            {!isAdmin && (
              <div className="bg-slate-100 hover:bg-slate-200/80 cursor-pointer rounded-full px-4 py-1.5 flex items-center gap-2 border transition-all" onClick={() => onNavigate('/wallet')}>
                <Wallet className="w-4 h-4 text-indigo-600" />
                <span className="text-sm font-extrabold text-slate-700">₹{user?.wallet_balance || '0.00'}</span>
              </div>
            )}

            <div className="flex items-center gap-3">
              <div className="w-9 h-9 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-sm">
                {user?.name ? user.name[0].toUpperCase() : 'U'}
              </div>
              <div className="hidden sm:block text-left">
                <div className="text-sm font-bold text-slate-800">{user?.name}</div>
                <div className="text-[10px] font-semibold text-slate-400 capitalize">{user?.role}</div>
              </div>
            </div>
          </div>
        </header>

        {/* Dynamic Mobile Nav Menu */}
        <AnimatePresence>
          {mobileOpen && (
            <motion.div 
              initial={{ opacity: 0, x: -100 }}
              animate={{ opacity: 1, x: 0 }}
              exit={{ opacity: 0, x: -100 }}
              className="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 lg:hidden flex"
              onClick={() => setMobileOpen(false)}
            >
              <div className="w-64 bg-slate-900 text-white flex flex-col p-6 space-y-6" onClick={e => e.stopPropagation()}>
                <div className="flex items-center gap-2 text-xl font-bold text-indigo-400">
                  <Car className="w-6 h-6" />
                  <span>Odoo Carpool</span>
                </div>
                <nav className="flex-1 space-y-1">
                  {menuItems.map((item, idx) => {
                    const Icon = item.icon;
                    const active = currentPath === item.path;
                    return (
                      <button
                        key={idx}
                        onClick={() => {
                          onNavigate(item.path);
                          setMobileOpen(false);
                        }}
                        className={`w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm transition-all text-left ${
                          active 
                            ? 'bg-indigo-600 text-white shadow-lg' 
                            : 'text-slate-400 hover:bg-slate-800 hover:text-white'
                        }`}
                      >
                        <Icon className="w-5 h-5" />
                        <span>{item.label}</span>
                      </button>
                    );
                  })}
                </nav>
                <div>
                  <button 
                    onClick={onLogout}
                    className="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-sm text-red-400 hover:bg-red-500/10 hover:text-white transition-all text-left"
                  >
                    <LogOut className="w-5 h-5" />
                    <span>Sign Out</span>
                  </button>
                </div>
              </div>
            </motion.div>
          )}
        </AnimatePresence>

        {/* View Content Panel */}
        <main className="flex-1 p-6 overflow-y-auto">
          {children}
        </main>
      </div>
    </div>
  );
}

// ============================================================================
// PAGE: User Dashboard
// ============================================================================
export function Dashboard({ user, onNavigate }) {
  const [trips, setTrips] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    api.getMyTrips().then(res => {
      setTrips(res.bookings || []);
      setLoading(false);
    }).catch(err => {
      console.error(err);
      setLoading(false);
    });
  }, []);

  return (
    <div className="space-y-6">
      {/* Welcome Card */}
      <div className="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-3xl p-6 lg:p-8 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center">
        <div className="absolute right-0 bottom-0 w-64 h-64 rounded-full bg-white/5 blur-3xl pointer-events-none" />
        <div>
          <h1 className="text-2xl lg:text-3xl font-extrabold mb-2">Welcome back, {user?.name}!</h1>
          <p className="text-white/80 text-sm max-w-md">Commute smartly with colleagues inside {user?.org_name}. Set your route or find rides easily.</p>
        </div>
        <div className="flex gap-3 mt-4 md:mt-0">
          <button onClick={() => onNavigate('/find-ride')} className="bg-white text-indigo-700 hover:bg-slate-50 font-bold px-5 py-2.5 rounded-full shadow-md text-sm transition-all active:scale-95 flex items-center gap-2">
            <Search className="w-4 h-4" /> Find Ride
          </button>
          <button onClick={() => onNavigate('/offer-ride')} className="bg-indigo-500/30 border border-white/20 hover:bg-indigo-500/50 text-white font-bold px-5 py-2.5 rounded-full shadow-md text-sm transition-all active:scale-95 flex items-center gap-2">
            <Plus className="w-4 h-4" /> Offer Ride
          </button>
        </div>
      </div>

      {/* Stats Summary Rows */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div className="bg-white border rounded-2xl p-5 shadow-sm flex items-center gap-4">
          <div className="bg-indigo-50 text-indigo-600 p-3.5 rounded-xl"><Car className="w-6 h-6" /></div>
          <div>
            <div className="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Bookings</div>
            <div className="text-xl font-extrabold text-slate-800">{trips.filter(t => t.status !== 'trip_completed' && t.status !== 'cancelled').length}</div>
          </div>
        </div>

        <div className="bg-white border rounded-2xl p-5 shadow-sm flex items-center gap-4">
          <div className="bg-emerald-50 text-emerald-600 p-3.5 rounded-xl"><Award className="w-6 h-6" /></div>
          <div>
            <div className="text-xs font-bold text-slate-400 uppercase tracking-wider">Carbon Saved</div>
            <div className="text-xl font-extrabold text-slate-800">42.8 KG</div>
          </div>
        </div>

        <div className="bg-white border rounded-2xl p-5 shadow-sm flex items-center gap-4">
          <div className="bg-amber-50 text-amber-600 p-3.5 rounded-xl"><Wallet className="w-6 h-6" /></div>
          <div>
            <div className="text-xs font-bold text-slate-400 uppercase tracking-wider">Saved Fuel cost</div>
            <div className="text-xl font-extrabold text-slate-800">₹2,840</div>
          </div>
        </div>
      </div>

      {/* Active Rides Table */}
      <div className="bg-white border rounded-2xl shadow-sm overflow-hidden">
        <div className="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
          <h3 className="font-extrabold text-slate-800 text-lg">Your Upcoming Carpools</h3>
          <button onClick={() => onNavigate('/my-trips')} className="text-xs font-bold text-indigo-600 hover:underline">View All</button>
        </div>

        {loading ? (
          <div className="p-8 text-center text-slate-400">Loading trips...</div>
        ) : trips.length === 0 ? (
          <div className="p-8 text-center text-slate-400">You don't have any booked carpool trips yet.</div>
        ) : (
          <div className="table-responsive">
            <table className="table table-borderless table-striped align-middle mb-0 text-sm">
              <thead className="border-b bg-slate-50 text-slate-500 font-bold">
                <tr>
                  <th className="py-3 px-6">Driver</th>
                  <th className="py-3 px-6">Route</th>
                  <th className="py-3 px-6">Date & Time</th>
                  <th className="py-3 px-6">Seats</th>
                  <th className="py-3 px-6">Fare</th>
                  <th className="py-3 px-6">Status</th>
                </tr>
              </thead>
              <tbody>
                {trips.slice(0, 5).map((trip, idx) => (
                  <tr key={idx} className="border-b hover:bg-slate-50/50 cursor-pointer" onClick={() => onNavigate(`/my-trips`)}>
                    <td className="py-3.5 px-6 font-bold text-slate-800">{trip.driver_name || 'Coworker'}</td>
                    <td className="py-3.5 px-6 max-w-xs truncate text-slate-600">
                      <span className="font-semibold text-slate-700">{trip.pickup_address.split(',')[0]}</span> to <span className="font-semibold text-slate-700">{trip.drop_address.split(',')[0]}</span>
                    </td>
                    <td className="py-3.5 px-6 text-slate-500">{trip.travel_date} at {trip.travel_time}</td>
                    <td className="py-3.5 px-6 text-slate-500">{trip.seats_booked} Seats</td>
                    <td className="py-3.5 px-6 font-extrabold text-slate-700">₹{trip.fare_amount}</td>
                    <td className="py-3.5 px-6">
                      <span className={`px-2.5 py-1 rounded-full text-xs font-bold ${
                        trip.status === 'booked' ? 'bg-indigo-50 text-indigo-700' :
                        trip.status === 'trip_completed' ? 'bg-green-50 text-green-700' :
                        trip.status === 'cancelled' ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700'
                      }`}>
                        {trip.status.replace('_', ' ')}
                      </span>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
      </div>
    </div>
  );
}

// ============================================================================
// PAGE: Find a Ride
// ============================================================================
export function FindRide({ onNavigate }) {
  const [pickup, setPickup] = useState('');
  const [drop, setDrop] = useState('');
  const [date, setDate] = useState('');
  const [results, setResults] = useState([]);
  const [loading, setLoading] = useState(false);
  const [searched, setSearched] = useState(false);
  const [bookingLoading, setBookingLoading] = useState(null);

  const handleSearch = async (e) => {
    e.preventDefault();
    setLoading(true);
    setSearched(true);
    try {
      const res = await api.searchRides({ 
        pickup_lat: 23.0225, // Mock coordinates matching Ahmedabad
        pickup_lng: 72.5714,
        drop_lat: 23.2156, // Gandhinagar
        drop_lng: 72.6369,
        travel_date: date,
        seats: 1
      });
      setResults(res.rides || []);
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  const handleBook = async (rideId, seats, fare) => {
    setBookingLoading(rideId);
    try {
      await api.bookRide({ ride_id: rideId, seats_booked: seats, fare_amount: fare });
      alert('Ride booked successfully!');
      onNavigate('/my-trips');
    } catch (err) {
      alert(err.message || 'Failed to book ride.');
    } finally {
      setBookingLoading(null);
    }
  };

  return (
    <div className="space-y-6">
      <div className="mb-4">
        <h1 className="text-2xl font-extrabold text-slate-800">Find Coworker Rides</h1>
        <p className="text-slate-500">Search active carpools matching your commute requirements.</p>
      </div>

      {/* Search form */}
      <div className="bg-white border rounded-2xl p-6 shadow-sm">
        <form onSubmit={handleSearch} className="grid grid-cols-1 md:grid-cols-4 gap-4 align-items-end">
          <div>
            <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">From (Pickup)</label>
            <div className="flex rounded-xl border border-slate-200 overflow-hidden bg-slate-50 px-3 py-2.5">
              <MapPin className="w-5 h-5 text-slate-400 mr-2" />
              <input type="text" placeholder="Pickup Address" value={pickup} onChange={e => setPickup(e.target.value)} required className="w-full bg-transparent border-0 outline-none text-sm" />
            </div>
          </div>
          <div>
            <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">To (Destination)</label>
            <div className="flex rounded-xl border border-slate-200 overflow-hidden bg-slate-50 px-3 py-2.5">
              <MapPin className="w-5 h-5 text-slate-400 mr-2" />
              <input type="text" placeholder="Drop Location" value={drop} onChange={e => setDrop(e.target.value)} required className="w-full bg-transparent border-0 outline-none text-sm" />
            </div>
          </div>
          <div>
            <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Date</label>
            <div className="flex rounded-xl border border-slate-200 overflow-hidden bg-slate-50 px-3 py-2.5">
              <Calendar className="w-5 h-5 text-slate-400 mr-2" />
              <input type="date" value={date} onChange={e => setDate(e.target.value)} required className="w-full bg-transparent border-0 outline-none text-sm" />
            </div>
          </div>
          <button type="submit" disabled={loading} className="w-full bg-indigo-600 text-white font-bold py-3 px-5 rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-500/20 active:scale-95 transition-all flex items-center justify-center gap-2">
            <Search className="w-4 h-4" /> {loading ? 'Searching...' : 'Search Rides'}
          </button>
        </form>
      </div>

      {/* Results */}
      {searched && (
        <div className="space-y-4">
          <h3 className="font-extrabold text-slate-800 text-lg">Search Results</h3>

          {loading ? (
            <div className="p-8 text-center text-slate-400">Searching coordinates & routes...</div>
          ) : results.length === 0 ? (
            <div className="bg-white border rounded-2xl p-8 text-center text-slate-500 shadow-sm">No active rides offered matching your schedule today. Try offering one!</div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              {results.map((ride, idx) => (
                <div key={idx} className="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm flex flex-col justify-between hover:shadow-md transition-all">
                  <div>
                    <div className="flex justify-between items-start mb-3">
                      <div>
                        <h4 className="font-extrabold text-slate-800">{ride.driver_name || 'Driver Coworker'}</h4>
                        <div className="text-xs text-indigo-600 font-bold uppercase tracking-wider">{ride.vehicle_model} • {ride.registration_number}</div>
                      </div>
                      <div className="text-right">
                        <span className="text-xl font-black text-slate-900">₹{ride.fare_per_seat}</span>
                        <div className="text-[10px] text-slate-400 font-bold uppercase">per seat</div>
                      </div>
                    </div>

                    <div className="space-y-2.5 my-4 text-sm text-slate-600">
                      <div className="flex items-center gap-2"><MapPin className="w-4 h-4 text-slate-400 flex-shrink-0" /> <span className="truncate">{ride.pickup_address}</span></div>
                      <div className="flex items-center gap-2"><MapPin className="w-4 h-4 text-slate-500 flex-shrink-0" /> <span className="truncate">{ride.drop_address}</span></div>
                      <div className="flex items-center gap-4 text-xs font-semibold text-slate-500">
                        <div className="flex items-center gap-1"><Calendar className="w-3.5 h-3.5" /> {ride.travel_date}</div>
                        <div className="flex items-center gap-1"><Clock className="w-3.5 h-3.5" /> {ride.travel_time}</div>
                        <div className="flex items-center gap-1"><Users className="w-3.5 h-3.5" /> {ride.available_seats} / {ride.total_seats} seats free</div>
                      </div>
                    </div>
                  </div>

                  <button 
                    onClick={() => handleBook(ride.id, 1, ride.fare_per_seat)}
                    disabled={bookingLoading === ride.id}
                    className="w-full bg-slate-900 text-white font-bold py-2.5 rounded-xl hover:bg-indigo-600 transition-all flex items-center justify-center gap-2 shadow-sm text-sm"
                  >
                    <Check className="w-4 h-4" /> {bookingLoading === ride.id ? 'Booking...' : 'Book Ride Seat'}
                  </button>
                </div>
              ))}
            </div>
          )}
        </div>
      )}
    </div>
  );
}

// ============================================================================
// PAGE: Offer a Ride
// ============================================================================
export function OfferRide({ onNavigate }) {
  const [vehicles, setVehicles] = useState([]);
  const [selectedVehicle, setSelectedVehicle] = useState('');
  const [pickup, setPickup] = useState('');
  const [drop, setDrop] = useState('');
  const [date, setDate] = useState('');
  const [time, setTime] = useState('');
  const [seats, setSeats] = useState(3);
  const [fare, setFare] = useState(8.00);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    api.getAdminVehicles().then(res => {
      setVehicles(res.vehicles || []);
      if (res.vehicles?.length > 0) {
        setSelectedVehicle(res.vehicles[0].id);
      }
    }).catch(err => console.error(err));
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    try {
      await api.offerRide({
        vehicle_id: selectedVehicle,
        pickup_address: pickup,
        pickup_lat: 23.0225, // Mock coordinates Ahmedabad
        pickup_lng: 72.5714,
        drop_address: drop,
        drop_lat: 23.2156, // Gandhinagar
        drop_lng: 72.6369,
        travel_date: date,
        travel_time: time,
        available_seats: seats,
        total_seats: seats,
        fare_per_seat: fare
      });
      alert('Ride offered successfully!');
      onNavigate('/dashboard');
    } catch (err) {
      alert(err.message || 'Failed to offer ride.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="space-y-6 max-w-xl mx-auto">
      <div className="mb-4">
        <h1 className="text-2xl font-extrabold text-slate-800">Publish a Carpool Ride</h1>
        <p className="text-slate-500">Offer your empty vehicle seats to colleagues and save commuting expenses.</p>
      </div>

      <div className="bg-white border rounded-2xl p-6 shadow-sm">
        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Select Vehicle</label>
            <select required value={selectedVehicle} onChange={e => setSelectedVehicle(e.target.value)} className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-slate-700 text-sm">
              {vehicles.map((v, idx) => (
                <option key={idx} value={v.id}>{v.model} ({v.registration_number})</option>
              ))}
              {vehicles.length === 0 && <option value="">No vehicles registered. Add one in dashboard.</option>}
            </select>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">From (Pickup location)</label>
              <input type="text" placeholder="Pickup Address" value={pickup} onChange={e => setPickup(e.target.value)} required className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm text-slate-700" />
            </div>
            <div>
              <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">To (Drop Location)</label>
              <input type="text" placeholder="Drop Address" value={drop} onChange={e => setDrop(e.target.value)} required className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm text-slate-700" />
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Date</label>
              <input type="date" value={date} onChange={e => setDate(e.target.value)} required className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm text-slate-700" />
            </div>
            <div>
              <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Time</label>
              <input type="time" value={time} onChange={e => setTime(e.target.value)} required className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm text-slate-700" />
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Available Seats</label>
              <input type="number" min="1" max="8" value={seats} onChange={e => setSeats(parseInt(e.target.value))} required className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm text-slate-700" />
            </div>
            <div>
              <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Fare per Seat (₹)</label>
              <input type="number" min="0" step="0.5" value={fare} onChange={e => setFare(parseFloat(e.target.value))} required className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm text-slate-700" />
            </div>
          </div>

          <button type="submit" disabled={loading} className="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-indigo-500/20 active:scale-95 transition-all mt-6 text-sm">
            {loading ? 'Publishing...' : 'Publish Carpool Ride'}
          </button>
        </form>
      </div>
    </div>
  );
}

// ============================================================================
// PAGE: My Trips (Bookings & Offers)
// ============================================================================
export function MyTrips() {
  const [activeTab, setActiveTab] = useState('booked');
  const [bookings, setBookings] = useState([]);
  const [offers, setOffers] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    api.getMyTrips().then(res => {
      setBookings(res.bookings || []);
      setOffers(res.offers || []);
      setLoading(false);
    }).catch(err => {
      console.error(err);
      setLoading(false);
    });
  }, []);

  return (
    <div className="space-y-6">
      <div className="mb-4">
        <h1 className="text-2xl font-extrabold text-slate-800">Your Carpools</h1>
        <p className="text-slate-500">Track and manage your booked rides and published driving offers.</p>
      </div>

      <div className="flex border-b border-slate-200 mb-6">
        <button onClick={() => setActiveTab('booked')} className={`px-6 py-2.5 font-bold text-sm border-b-2 transition-all ${
          activeTab === 'booked' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-400 hover:text-slate-600'
        }`}>
          Booked Trips (Passenger)
        </button>
        <button onClick={() => setActiveTab('offered')} className={`px-6 py-2.5 font-bold text-sm border-b-2 transition-all ${
          activeTab === 'offered' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-400 hover:text-slate-600'
        }`}>
          Offered Rides (Driver)
        </button>
      </div>

      {loading ? (
        <div className="text-center text-slate-400 p-8">Loading history...</div>
      ) : activeTab === 'booked' ? (
        <div className="bg-white border rounded-2xl shadow-sm overflow-hidden">
          {bookings.length === 0 ? (
            <div className="p-8 text-center text-slate-400">You haven't booked any rides.</div>
          ) : (
            <div className="table-responsive">
              <table className="table table-borderless table-striped align-middle mb-0 text-sm">
                <thead className="border-b bg-slate-50 text-slate-500 font-bold">
                  <tr>
                    <th className="py-3 px-6">Driver</th>
                    <th className="py-3 px-6">Route</th>
                    <th className="py-3 px-6">Date & Time</th>
                    <th className="py-3 px-6">Seats</th>
                    <th className="py-3 px-6">Fare</th>
                    <th className="py-3 px-6">Status</th>
                  </tr>
                </thead>
                <tbody>
                  {bookings.map((booking, idx) => (
                    <tr key={idx} className="border-b">
                      <td className="py-3.5 px-6 font-bold text-slate-800">{booking.driver_name}</td>
                      <td className="py-3.5 px-6 text-slate-600">{booking.pickup_address} to {booking.drop_address}</td>
                      <td className="py-3.5 px-6 text-slate-500">{booking.travel_date} at {booking.travel_time}</td>
                      <td className="py-3.5 px-6">{booking.seats_booked}</td>
                      <td className="py-3.5 px-6 font-bold">₹{booking.fare_amount}</td>
                      <td className="py-3.5 px-6">
                        <span className={`px-2.5 py-1 rounded-full text-xs font-bold ${
                          booking.status === 'booked' ? 'bg-indigo-50 text-indigo-700' :
                          booking.status === 'trip_completed' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'
                        }`}>
                          {booking.status}
                        </span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>
      ) : (
        <div className="bg-white border rounded-2xl shadow-sm overflow-hidden">
          {offers.length === 0 ? (
            <div className="p-8 text-center text-slate-400">You haven't offered any driving routes.</div>
          ) : (
            <div className="table-responsive">
              <table className="table table-borderless table-striped align-middle mb-0 text-sm">
                <thead className="border-b bg-slate-50 text-slate-500 font-bold">
                  <tr>
                    <th className="py-3 px-6">Route</th>
                    <th className="py-3 px-6">Date & Time</th>
                    <th className="py-3 px-6">Available Seats</th>
                    <th className="py-3 px-6">Fare per Seat</th>
                    <th className="py-3 px-6">Status</th>
                  </tr>
                </thead>
                <tbody>
                  {offers.map((offer, idx) => (
                    <tr key={idx} className="border-b">
                      <td className="py-3.5 px-6 text-slate-600">{offer.pickup_address} to {offer.drop_address}</td>
                      <td className="py-3.5 px-6 text-slate-500">{offer.travel_date} at {offer.travel_time}</td>
                      <td className="py-3.5 px-6">{offer.available_seats} / {offer.total_seats}</td>
                      <td className="py-3.5 px-6 font-bold">₹{offer.fare_per_seat}</td>
                      <td className="py-3.5 px-6">
                        <span className="px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700">
                          {offer.status}
                        </span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>
      )}
    </div>
  );
}

// ============================================================================
// PAGE: Wallet Management
// ============================================================================
export function WalletPanel() {
  const [balance, setBalance] = useState('0.00');
  const [transactions, setTransactions] = useState([]);
  const [amount, setAmount] = useState('');
  const [loading, setLoading] = useState(false);

  const fetchWalletData = () => {
    api.getWallet().then(res => {
      setBalance(res.balance || '0.00');
      setTransactions(res.transactions || []);
    }).catch(err => console.error(err));
  };

  useEffect(() => {
    fetchWalletData();
  }, []);

  const handleRecharge = async (e) => {
    e.preventDefault();
    if (parseFloat(amount) <= 0) return;
    setLoading(true);
    try {
      const refId = 'TXN_' + Math.random().toString(36).substr(2, 9).toUpperCase();
      await api.rechargeWallet(amount, refId);
      alert('Wallet recharged successfully (Simulation success)!');
      setAmount('');
      fetchWalletData();
    } catch (err) {
      alert(err.message || 'Recharge failed.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="space-y-6">
      <div className="mb-4">
        <h1 className="text-2xl font-extrabold text-slate-800">Coworker Wallet</h1>
        <p className="text-slate-500">Manage your balance and view travel cost payouts and debits.</p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        {/* Wallet card */}
        <div className="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-3xl p-6 text-white shadow-xl flex flex-col justify-between h-48 relative overflow-hidden md:col-span-1">
          <div className="absolute right-0 bottom-0 w-32 h-32 rounded-full bg-white/5 blur-2xl pointer-events-none" />
          <div className="flex justify-between items-center">
            <span className="text-xs font-bold uppercase tracking-wider text-white/80">Active Balance</span>
            <Wallet className="w-5 h-5 text-white/90" />
          </div>
          <div>
            <h2 className="text-4xl font-black mb-1">₹{balance}</h2>
            <div className="text-[10px] text-white/70 font-semibold uppercase tracking-wider">Odoo Wallet Card</div>
          </div>
        </div>

        {/* Recharge Form */}
        <div className="bg-white border rounded-3xl p-6 shadow-sm md:col-span-2 flex flex-col justify-between">
          <div>
            <h3 className="font-extrabold text-slate-800 mb-2">Simulate Card Recharge</h3>
            <p className="text-slate-500 text-xs mb-4">Add dummy funds directly to verify wallet splits and booking confirmations.</p>
          </div>
          <form onSubmit={handleRecharge} className="flex gap-3">
            <div className="flex-1 flex rounded-xl border border-slate-200 overflow-hidden bg-slate-50 px-3 py-2">
              <span className="text-slate-400 font-bold text-sm mr-2 flex items-center">₹</span>
              <input 
                type="number" 
                min="10" 
                step="50" 
                required 
                value={amount}
                onChange={e => setAmount(e.target.value)}
                placeholder="Enter amount (e.g. 500)" 
                className="w-full bg-transparent border-0 outline-none text-sm font-semibold"
              />
            </div>
            <button type="submit" disabled={loading} className="bg-indigo-600 text-white font-bold px-6 py-2.5 rounded-xl hover:bg-indigo-700 active:scale-95 transition-all text-sm">
              {loading ? 'Processing...' : 'Load Funds'}
            </button>
          </form>
        </div>
      </div>

      {/* Transactions Table */}
      <div className="bg-white border rounded-2xl shadow-sm overflow-hidden">
        <div className="px-6 py-4 border-b border-slate-100">
          <h3 className="font-extrabold text-slate-800 text-lg">Transaction Ledger</h3>
        </div>

        {transactions.length === 0 ? (
          <div className="p-8 text-center text-slate-400">No transactions recorded yet.</div>
        ) : (
          <div className="table-responsive">
            <table className="table table-borderless table-striped align-middle mb-0 text-sm">
              <thead className="border-b bg-slate-50 text-slate-500 font-bold">
                <tr>
                  <th className="py-3 px-6">Reference ID</th>
                  <th className="py-3 px-6">Type</th>
                  <th className="py-3 px-6">Amount</th>
                  <th className="py-3 px-6">Date</th>
                </tr>
              </thead>
              <tbody>
                {transactions.map((tx, idx) => (
                  <tr key={idx} className="border-b">
                    <td className="py-3.5 px-6 font-mono text-slate-600">{tx.reference || 'N/A'}</td>
                    <td className="py-3.5 px-6">
                      <span className={`px-2 py-0.5 rounded text-xs font-bold uppercase ${
                        tx.type === 'recharge' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'
                      }`}>
                        {tx.type}
                      </span>
                    </td>
                    <td className="py-3.5 px-6 font-bold text-slate-800">
                      {tx.type === 'recharge' ? '+' : '-'}₹{tx.amount}
                    </td>
                    <td className="py-3.5 px-6 text-slate-400">{tx.created_at}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
      </div>
    </div>
  );
}

// ============================================================================
// COMPONENT: ADMIN PORTAL SUB-HEADER/TABS LAYOUT
// ============================================================================
function AdminTabContainer({ stats, currentTab, onNavigate, children }) {
  return (
    <div className="space-y-6">
      {/* Top Header stats */}
      <div className="flex justify-between items-center mb-4">
        <div>
          <h1 className="text-2xl font-extrabold text-slate-800">{stats?.org?.name || 'Company Portal'}</h1>
          <p className="text-slate-500">Corporate moderation dashboard settings.</p>
        </div>
        <span className="badge bg-red-100 text-red-700 font-extrabold px-3 py-1.5 rounded-full text-xs uppercase tracking-wider">Admin</span>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div className="bg-white border rounded-2xl p-5 shadow-sm">
          <div className="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Employees</div>
          <div className="text-2xl font-black text-indigo-600">{stats?.total_employees || 0}</div>
        </div>
        <div className="bg-white border rounded-2xl p-5 shadow-sm">
          <div className="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Registered Vehicles</div>
          <div className="text-2xl font-black text-indigo-600">{stats?.registered_vehicles || 0}</div>
        </div>
        <div className="bg-white border rounded-2xl p-5 shadow-sm">
          <div className="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Rides Published</div>
          <div className="text-2xl font-black text-indigo-600">{stats?.total_rides || 0}</div>
        </div>
      </div>

      {/* Tabs */}
      <div className="flex border-b border-slate-200">
        <button onClick={() => onNavigate('/admin/dashboard')} className={`px-6 py-2.5 font-bold text-sm border-b-2 transition-all ${
          currentTab === 'employees' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-400 hover:text-slate-600'
        }`}>
          Employees
        </button>
        <button onClick={() => onNavigate('/admin/vehicles')} className={`px-6 py-2.5 font-bold text-sm border-b-2 transition-all ${
          currentTab === 'vehicles' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-400 hover:text-slate-600'
        }`}>
          Vehicles
        </button>
        <button onClick={() => onNavigate('/admin/settings')} className={`px-6 py-2.5 font-bold text-sm border-b-2 transition-all ${
          currentTab === 'settings' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-400 hover:text-slate-600'
        }`}>
          Settings
        </button>
      </div>

      <div className="bg-white border rounded-2xl p-6 shadow-sm">
        {children}
      </div>
    </div>
  );
}

// ============================================================================
// PAGE: Admin Employees Panel
// ============================================================================
export function AdminEmployees({ onNavigate }) {
  const [stats, setStats] = useState(null);
  const [employees, setEmployees] = useState([]);
  const [resets, setResets] = useState([]);
  const [loading, setLoading] = useState(true);

  const mockDepts = ['Engineering', 'Finance', 'HR', 'Marketing', 'Sales'];
  const mockMgrs = ['A. Shah', 'R. Mehta', 'P. Desai', 'S. Patel'];
  const mockLocs = ['Ahmedabad', 'Gandhinagar', 'Vadodara'];

  const fetchData = () => {
    api.getAdminEmployees().then(res => {
      setStats(res.stats || null);
      setEmployees(res.employees || []);
      setResets(res.resetRequests || []);
      setLoading(false);
    }).catch(err => {
      console.error(err);
      setLoading(false);
    });
  };

  useEffect(() => {
    fetchData();
  }, []);

  const toggleAccess = async (userId, currentStatus) => {
    const nextStatus = currentStatus === 'active' ? 'inactive' : 'active';
    if (!confirm(`Are you sure you want to change this employee's access status?`)) return;
    try {
      await api.toggleEmployeeAccess(userId, nextStatus);
      fetchData();
    } catch (err) {
      alert(err.message || 'Failed to update access.');
    }
  };

  if (loading) return <div className="text-center text-slate-400 p-8">Loading employees...</div>;

  return (
    <AdminTabContainer stats={stats} currentTab="employees" onNavigate={onNavigate}>
      <h3 className="font-extrabold text-slate-800 text-lg mb-4">Active Coworkers Registry</h3>
      <div className="table-responsive -mx-6">
        <table className="table table-borderless table-striped align-middle mb-0 text-sm">
          <thead className="border-b bg-slate-50 text-slate-500 font-bold">
            <tr>
              <th className="py-3 px-6">Name</th>
              <th className="py-3 px-6">Email</th>
              <th className="py-3 px-6">Department</th>
              <th className="py-3 px-6">Manager</th>
              <th className="py-3 px-6">Location</th>
              <th className="py-3 px-6">Access</th>
            </tr>
          </thead>
          <tbody>
            {employees.map((emp, idx) => {
              const dept = mockDepts[emp.id % mockDepts.length];
              const mgr = mockMgrs[emp.id % mockMgrs.length];
              const loc = mockLocs[emp.id % mockLocs.length];
              return (
                <tr key={idx} className="border-b">
                  <td className="py-3 px-6 font-bold text-slate-800">{emp.name}</td>
                  <td className="py-3 px-6 text-slate-600">{emp.email}</td>
                  <td className="py-3 px-6 text-slate-500">{dept}</td>
                  <td className="py-3 px-6 text-slate-500">{mgr}</td>
                  <td className="py-3 px-6 text-slate-500">{loc}</td>
                  <td className="py-3 px-6">
                    <button 
                      onClick={() => toggleAccess(emp.id, emp.status)}
                      className={`font-bold hover:underline ${emp.status === 'active' ? 'text-green-600' : 'text-red-500'}`}
                    >
                      {emp.status === 'active' ? '[Granted]' : '[Revoked]'}
                    </button>
                  </td>
                </tr>
              );
            })}
          </tbody>
        </table>
      </div>

      {/* Password Reset Requests */}
      <div className="mt-8 border-t pt-8">
        <h3 className="font-extrabold text-slate-800 text-lg mb-1 flex items-center gap-2">
          <Shield className="w-5 h-5 text-indigo-500" /> Password Reset Requests
        </h3>
        <p className="text-xs text-slate-500 mb-4">Provide these 4-digit codes to employees who requested password recovery.</p>
        
        <div className="table-responsive -mx-6">
          <table className="table table-borderless table-striped align-middle mb-0 text-sm">
            <thead className="border-b bg-slate-50 text-slate-500 font-bold">
              <tr>
                <th className="py-3 px-6">Request Email</th>
                <th className="py-3 px-6">Generated Code</th>
                <th className="py-3 px-6">Requested At</th>
                <th className="py-3 px-6">Status</th>
              </tr>
            </thead>
            <tbody>
              {resets.map((req, idx) => (
                <tr key={idx} className="border-b">
                  <td className="py-3.5 px-6 font-bold text-slate-800">{req.email}</td>
                  <td className="py-3.5 px-6">
                    <span className="bg-amber-100 text-amber-800 font-extrabold font-mono px-3 py-1.5 rounded-lg text-sm tracking-wider">
                      {req.code}
                    </span>
                  </td>
                  <td className="py-3.5 px-6 text-slate-400">{req.created_at}</td>
                  <td className="py-3.5 px-6">
                    <span className={`px-2 py-0.5 rounded text-[10px] font-bold uppercase ${
                      req.status === 'pending' ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700'
                    }`}>
                      {req.status}
                    </span>
                  </td>
                </tr>
              ))}
              {resets.length === 0 && (
                <tr>
                  <td colspan="4" className="p-8 text-center text-slate-400">No active recovery requests.</td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>
    </AdminTabContainer>
  );
}

// ============================================================================
// PAGE: Admin Vehicles Panel
// ============================================================================
export function AdminVehicles({ onNavigate }) {
  const [stats, setStats] = useState(null);
  const [vehicles, setVehicles] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    api.getAdminVehicles().then(res => {
      setStats(res.stats || null);
      setVehicles(res.vehicles || []);
      setLoading(false);
    }).catch(err => {
      console.error(err);
      setLoading(false);
    });
  }, []);

  if (loading) return <div className="text-center text-slate-400 p-8">Loading vehicles...</div>;

  return (
    <AdminTabContainer stats={stats} currentTab="vehicles" onNavigate={onNavigate}>
      <h3 className="font-extrabold text-slate-800 text-lg mb-4">Moderate Registered Vehicles</h3>
      <div className="table-responsive -mx-6">
        <table className="table table-borderless table-striped align-middle mb-0 text-sm">
          <thead className="border-b bg-slate-50 text-slate-500 font-bold">
            <tr>
              <th className="py-3 px-6">Registration Number</th>
              <th className="py-3 px-6">Model</th>
              <th className="py-3 px-6">Capacity</th>
              <th className="py-3 px-6">Driver</th>
              <th className="py-3 px-6">Status</th>
            </tr>
          </thead>
          <tbody>
            {vehicles.map((v, idx) => (
              <tr key={idx} className="border-b">
                <td className="py-3 px-6 font-bold text-slate-800">{v.registration_number}</td>
                <td className="py-3 px-6 text-slate-600">{v.model}</td>
                <td className="py-3 px-6 text-slate-500">{v.seating_capacity} seats</td>
                <td className="py-3 px-6 text-slate-500">{v.owner_name}</td>
                <td className="py-3 px-6">
                  <span className={`px-2 py-0.5 rounded text-xs font-bold ${
                    v.status === 'approved' || v.status === 'active' ? 'text-green-600' : 'text-red-500'
                  }`}>
                    {v.status === 'approved' || v.status === 'active' ? '[Active]' : '[Inactive]'}
                  </span>
                </td>
              </tr>
            ))}
            {vehicles.length === 0 && (
              <tr>
                <td colspan="5" className="p-8 text-center text-slate-400">No vehicles registered.</td>
              </tr>
            )}
          </tbody>
        </table>
      </div>
    </AdminTabContainer>
  );
}

// ============================================================================
// PAGE: Admin Settings Panel
// ============================================================================
export function AdminSettings({ onNavigate }) {
  const [stats, setStats] = useState(null);
  const [org, setOrg] = useState(null);
  const [fuel, setFuel] = useState('96.50');
  const [fare, setFare] = useState('8.00');
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    api.getAdminSettings().then(res => {
      setStats(res.stats || null);
      setOrg(res.org || null);
      if (res.org) {
        setFuel(res.org.fuel_cost_per_km);
        setFare(res.org.default_fare_per_km);
      }
      setLoading(false);
    }).catch(err => {
      console.error(err);
      setLoading(false);
    });
  }, []);

  const handleSave = async (e) => {
    e.preventDefault();
    try {
      await api.saveAdminSettings({
        fuel_cost_per_km: fuel,
        default_fare_per_km: fare
      });
      alert('Settings saved successfully!');
    } catch (err) {
      alert(err.message || 'Failed to save settings.');
    }
  };

  if (loading) return <div className="text-center text-slate-400 p-8">Loading settings...</div>;

  return (
    <AdminTabContainer stats={stats} currentTab="settings" onNavigate={onNavigate}>
      <form onSubmit={handleSave} className="space-y-8">
        <div>
          <h4 className="font-extrabold text-slate-800 text-lg border-b pb-2 mb-4">Company Details</h4>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div className="flex border-b border-slate-100 pb-2">
              <span className="text-slate-400 w-1/2">Company Name</span>
              <span className="font-bold text-slate-700 w-1/2">{org?.name}</span>
            </div>
            <div className="flex border-b border-slate-100 pb-2">
              <span className="text-slate-400 w-1/2">Industry</span>
              <span className="font-bold text-slate-700 w-1/2">Software</span>
            </div>
            <div className="flex border-b border-slate-100 pb-2">
              <span className="text-slate-400 w-1/2">Registered Address</span>
              <span className="font-bold text-slate-700 w-1/2">Gandhinagar</span>
            </div>
            <div className="flex border-b border-slate-100 pb-2">
              <span className="text-slate-400 w-1/2">Admin Contact</span>
              <span className="font-bold text-slate-700 w-1/2">admin@{org?.domain}</span>
            </div>
          </div>
        </div>

        <div>
          <h4 className="font-extrabold text-slate-800 text-lg border-b pb-2 mb-4">Carpooling Configuration</h4>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Fuel Cost / Liter (₹)</label>
              <input type="text" className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm text-slate-700 font-semibold" value="Rs. 96.50" disabled />
            </div>
            
            <div>
              <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cost Per KM (₹)</label>
              <input 
                type="number" 
                step="0.5" 
                required 
                value={fare} 
                onChange={e => setFare(e.target.value)} 
                className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm text-slate-700 font-semibold focus:border-indigo-600 focus:bg-white transition-all" 
              />
            </div>

            <div>
              <label className="form-label block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Travel Cost (Operational) / Km (₹)</label>
              <input 
                type="number" 
                step="0.5" 
                required 
                value={fuel} 
                onChange={e => setFuel(e.target.value)} 
                className="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm text-slate-700 font-semibold focus:border-indigo-600 focus:bg-white transition-all" 
              />
            </div>
          </div>
        </div>

        <button type="submit" className="bg-indigo-600 text-white font-bold px-6 py-2.5 rounded-xl hover:bg-indigo-700 shadow-md active:scale-95 transition-all text-sm">
          Save Settings
        </button>
      </form>
    </AdminTabContainer>
  );
}
