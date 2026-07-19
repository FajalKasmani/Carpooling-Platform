<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RideShare — Enterprise Carpooling</title>
    <meta name="description" content="Share the commute, not the traffic. Corporate carpooling for verified employees.">
    <link rel="icon" type="image/svg+xml" href="<?= $baseUrl ?? '' ?>/favicon.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <style>
        :root{
            --bg:#F8F9FA;--bg-soft:#FFFFFF;--bg-card:#FFFFFF;
            --text:#0F172A;--text-muted:#475569;--text-faint:#94A3B8;
            --border:rgba(15,23,42,0.06);--border-md:rgba(15,23,42,0.12);
            --accent:#6C63FF;--accent-soft:rgba(108,99,255,0.08);--accent-glow:rgba(108,99,255,0.18);
            --teal:#0ea5e9;--teal-soft:rgba(14,165,233,0.08);
            --orange:#FF6B35;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        @media(prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important;}}
        html{scroll-behavior:smooth;}
        body{font-family:'Inter',sans-serif;-webkit-font-smoothing:antialiased;background:var(--bg);color:var(--text);}
        h1,h2,h3,h4{font-family:'Outfit',sans-serif;letter-spacing:-0.025em;}
        .mono{font-family:'JetBrains Mono',monospace;}
        a{color:inherit;text-decoration:none;}
        button{font-family:inherit;cursor:pointer;}
        @keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
        @keyframes draw{to{stroke-dashoffset:0;}}
        @keyframes shimmer{0%{background-position:-200% center;}100%{background-position:200% center;}}
        @keyframes float{0%,100%{transform:translateY(0);}50%{transform:translateY(-8px);}}
        @keyframes glow-pulse{0%,100%{opacity:0.6;}50%{opacity:1;}}
        .reveal{opacity:0;animation:fadeUp .6s cubic-bezier(.16,1,.3,1) forwards;}

        /* ── Nav ── */
        .l-nav{display:flex;align-items:center;justify-content:space-between;max-width:1200px;margin:0 auto;padding:28px 36px;}
        .brand{display:flex;align-items:center;gap:10px;font-family:'Outfit',sans-serif;font-weight:700;font-size:16px;color:var(--text);letter-spacing:-0.02em;}
        .brand svg{width:22px;height:22px;flex-shrink:0;}
        .brand-dot{width:6px;height:6px;border-radius:50%;background:var(--teal);box-shadow:0 0 8px var(--teal);animation:glow-pulse 2.5s ease-in-out infinite;}
        .l-nav-right{display:flex;align-items:center;gap:16px;}
        .l-nav-right a{font-size:13px;font-weight:500;color:var(--text-muted);padding:8px 16px;border-radius:100px;transition:color .15s,background .15s;}
        .l-nav-right a:hover{color:var(--text);background:rgba(0,0,0,0.04);}
        .btn-pill{background:linear-gradient(135deg,#6C63FF,#8A81FF);color:#fff;padding:10px 22px;border-radius:100px;font-size:13px;font-weight:600;border:none;cursor:pointer;transition:transform .15s,box-shadow .15s;box-shadow:0 4px 18px -4px rgba(108,99,255,0.45);}
        .btn-pill:hover{transform:translateY(-2px);box-shadow:0 8px 24px -4px rgba(108,99,255,0.55);}
        .btn-accent-lg{background:linear-gradient(135deg,#6C63FF,#8A81FF);color:#fff;padding:14px 28px;border-radius:100px;font-size:14px;font-weight:600;border:none;cursor:pointer;transition:transform .15s,box-shadow .15s;text-decoration:none;display:inline-flex;align-items:center;gap:8px;box-shadow:0 6px 24px -6px rgba(108,99,255,0.5);}
        .btn-accent-lg:hover{transform:translateY(-2px);box-shadow:0 12px 32px -6px rgba(108,99,255,0.6);color:#fff;}
        .btn-outline-hero{padding:14px 28px;border-radius:100px;font-size:14px;font-weight:600;border:1px solid rgba(15,23,42,0.12);background:rgba(15,23,42,0.04);color:var(--text);cursor:pointer;transition:border-color .15s,background .15s;display:inline-flex;align-items:center;gap:8px;}
        .btn-outline-hero:hover{border-color:rgba(15,23,42,0.25);background:rgba(15,23,42,0.08);}

        /* ── Hero ── */
        .l-hero{max-width:1200px;margin:0 auto;padding:60px 36px 80px;display:grid;grid-template-columns:1.15fr .85fr;gap:60px;align-items:center;}
        @media(max-width:900px){.l-hero{grid-template-columns:1fr;gap:40px;padding:40px 20px 60px;}.l-nav{padding:20px;}}
        .eyebrow-pill{display:inline-flex;align-items:center;gap:7px;border:1px solid rgba(108,99,255,0.25);border-radius:100px;padding:7px 14px;font-size:11.5px;font-weight:600;color:var(--accent);margin-bottom:22px;background:var(--accent-soft);}
        .eyebrow-pill svg{width:12px;height:12px;}
        .l-hero h1{font-size:clamp(38px,5vw,56px);line-height:1.05;font-weight:800;margin-bottom:20px;}
        .l-hero h1 span{background:linear-gradient(135deg,#6C63FF,#00D4AA);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
        .l-hero p{font-size:15.5px;color:var(--text-muted);line-height:1.7;max-width:460px;margin-bottom:34px;}
        .l-hero-actions{display:flex;gap:12px;flex-wrap:wrap;align-items:center;}

        /* ── Visual side ── */
        .l-visual{position:relative;}
        .visual-card{background:var(--bg-card);border:1px solid var(--border);border-radius:20px;padding:24px;overflow:hidden;position:relative;}
        .visual-card::before{content:'';position:absolute;top:-30%;left:-10%;width:260px;height:260px;background:radial-gradient(circle,rgba(108,99,255,0.1) 0%,transparent 70%);pointer-events:none;}
        .visual-card-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(0,212,170,0.1);border:1px solid rgba(0,212,170,0.2);border-radius:100px;padding:5px 12px;font-size:11px;font-weight:600;color:var(--teal);margin-bottom:16px;}
        .dot-live{width:6px;height:6px;border-radius:50%;background:var(--teal);animation:glow-pulse 1.8s ease-in-out infinite;}
        .route-line{position:relative;padding-left:20px;margin-bottom:12px;}
        .route-line::before{content:'';position:absolute;left:5px;top:8px;bottom:-12px;width:1.5px;background:linear-gradient(to bottom,rgba(108,99,255,0.5),rgba(0,212,170,0.5));border-radius:2px;}
        .route-dot{position:absolute;left:1px;top:5px;width:9px;height:9px;border-radius:50%;}
        .route-dot.a{background:#6C63FF;box-shadow:0 0 8px rgba(108,99,255,0.6);}
        .route-dot.b{background:#00D4AA;box-shadow:0 0 8px rgba(0,212,170,0.6);top:auto;bottom:-4px;}
        .route-text{font-size:12.5px;font-weight:500;color:var(--text-muted);}
        .route-text strong{color:var(--text);display:block;font-size:13px;}
        .l-stat-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:var(--border);border:1px solid var(--border);border-radius:14px;overflow:hidden;margin-top:20px;}
        .l-stat-cell{background:var(--bg-card);padding:18px 16px;}
        .l-stat-num{font-size:20px;font-weight:700;font-family:'JetBrains Mono',monospace;color:var(--text);}
        .l-stat-num.teal{color:var(--teal);}
        .l-stat-num.accent{color:var(--accent);}
        .l-stat-cap{font-size:10.5px;color:var(--text-faint);margin-top:4px;}

        /* ── Features ── */
        .l-section{max-width:1200px;margin:0 auto;padding:80px 36px;border-top:1px solid var(--border);}
        .l-section-head{margin-bottom:48px;max-width:540px;}
        .l-section-head .eyebrow{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--accent);margin-bottom:12px;}
        .l-section-head h2{font-size:34px;font-weight:700;line-height:1.15;color:var(--text);}
        .l-section-head p{color:var(--text-muted);font-size:14.5px;margin-top:12px;line-height:1.7;}
        .feat-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:var(--border);border:1px solid var(--border);border-radius:20px;overflow:hidden;}
        @media(max-width:700px){.feat-grid{grid-template-columns:1fr;}}
        .feat{background:var(--bg-card);padding:36px 32px;transition:background .2s ease;}
        .feat:hover{background:rgba(108,99,255,0.04);}
        .feat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:22px;}
        .feat-icon.a{background:rgba(108,99,255,0.12);color:var(--accent);}
        .feat-icon.b{background:rgba(0,212,170,0.12);color:var(--teal);}
        .feat-icon.c{background:rgba(255,107,53,0.12);color:var(--orange);}
        .feat-icon svg{width:22px;height:22px;}
        .feat h3{font-size:16px;font-weight:700;margin-bottom:10px;color:var(--text);}
        .feat p{font-size:13.5px;color:var(--text-muted);line-height:1.65;margin:0;}

        /* ── Footer ── */
        .l-footer{max-width:1200px;margin:0 auto;padding:32px 36px 60px;display:flex;justify-content:space-between;align-items:center;color:var(--text-faint);font-size:12px;border-top:1px solid var(--border);flex-wrap:wrap;gap:12px;}
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="l-nav reveal" style="animation-delay:.02s">
        <div class="brand">
            <svg viewBox="0 0 24 24" fill="none" stroke="#6C63FF" stroke-width="1.8">
                <path d="M3 16c3-6 5-9 9-9s6 3 9 9" stroke-linecap="round"/>
                <circle cx="6" cy="18" r="1.4" fill="#6C63FF" stroke="none"/>
                <circle cx="18" cy="18" r="1.4" fill="#00D4AA" stroke="none"/>
            </svg>
            RideShare
            <span class="brand-dot ms-2"></span>
        </div>
        <div class="l-nav-right">
            <a href="<?= $baseUrl ?? '' ?>/login">Sign in</a>
            <button class="btn-pill" onclick="window.location='<?= $baseUrl ?? '' ?>/register'">Get started</button>
        </div>
    </nav>

    <!-- Hero -->
    <div class="l-hero">
        <div class="reveal" style="animation-delay:.08s">
            <div class="eyebrow-pill">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                Enterprise verified employees only
            </div>
            <h1>Share the commute,<br>not the <span>traffic.</span></h1>
            <p>Find or offer a ride with verified colleagues on your route, split the fare automatically, and track your saved carbon footprint over time.</p>
            <div class="l-hero-actions">
                <a href="<?= $baseUrl ?? '' ?>/register" class="btn-accent-lg">
                    <i class="bi bi-arrow-right-circle-fill"></i>
                    Get started free
                </a>
                <button class="btn-outline-hero" onclick="document.getElementById('features').scrollIntoView({behavior:'smooth'})">
                    <i class="bi bi-play-circle"></i>
                    See how it works
                </button>
            </div>
        </div>

        <div class="l-visual reveal" style="animation-delay:.18s">
            <div class="visual-card">
                <div class="visual-card-badge">
                    <span class="dot-live"></span> 3 rides available now
                </div>

                <!-- Animated SVG route -->
                <svg viewBox="0 0 300 120" width="100%" fill="none" style="display:block;margin-bottom:16px;">
                    <path id="landPath"
                        d="M10 90 C 60 90, 60 30, 150 30 S 250 70, 290 20"
                        stroke="url(#routeGrad)" stroke-width="1.5" stroke-linecap="round"
                        stroke-dasharray="400" stroke-dashoffset="400"/>
                    <defs>
                        <linearGradient id="routeGrad" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0%" stop-color="#6C63FF"/>
                            <stop offset="100%" stop-color="#00D4AA"/>
                        </linearGradient>
                    </defs>
                    <circle cx="10" cy="90" r="5" fill="#6C63FF"/>
                    <circle cx="290" cy="20" r="5" fill="#00D4AA"/>
                    <circle r="4" fill="#fff">
                        <animateMotion dur="3.6s" repeatCount="indefinite"
                            path="M10 90 C 60 90, 60 30, 150 30 S 250 70, 290 20"/>
                    </circle>
                </svg>

                <div style="display:flex;gap:16px;">
                    <div class="route-line" style="flex:1;">
                        <span class="route-dot a"></span>
                        <div class="route-text"><strong>Sector 62, Noida</strong>Home pickup</div>
                    </div>
                    <div style="padding:5px 0;color:rgba(15,23,42,0.15);font-size:18px;">→</div>
                    <div class="route-line" style="flex:1;">
                        <span class="route-dot b"></span>
                        <div class="route-text"><strong>Cyber City, Gurugram</strong>Office campus</div>
                    </div>
                </div>
            </div>

            <div class="l-stat-strip">
                <div class="l-stat-cell">
                    <div class="l-stat-num accent mono">30+</div>
                    <div class="l-stat-cap">Active commuters</div>
                </div>
                <div class="l-stat-cell">
                    <div class="l-stat-num mono">10+</div>
                    <div class="l-stat-cap">Verified vehicles</div>
                </div>
                <div class="l-stat-cell">
                    <div class="l-stat-num teal mono">1.2k+</div>
                    <div class="l-stat-cap">CO₂ saved (kg)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features -->
    <section class="l-section" id="features">
        <div class="l-section-head reveal">
            <div class="eyebrow">How it works</div>
            <h2>Three tools, one daily commute.</h2>
            <p>Built specifically for how your organization actually gets to work — matched routes, a shared wallet, and a live map for the ride itself.</p>
        </div>
        <div class="feat-grid reveal" style="animation-delay:.08s">
            <div class="feat">
                <div class="feat-icon a">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>
                    </svg>
                </div>
                <h3>Find a ride instantly</h3>
                <p>Search by pickup, drop, and time. See verified drivers, live seats, and fares before you book.</p>
            </div>
            <div class="feat">
                <div class="feat-icon b">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 13l1.5-5A2 2 0 0 1 6.4 6.5h11.2a2 2 0 0 1 1.9 1.5L21 13"/><rect x="3" y="13" width="18" height="6" rx="1.5"/>
                    </svg>
                </div>
                <h3>Offer your route</h3>
                <p>Publish your commute with your registered vehicle. Fare per seat is suggested from company fuel rates.</p>
            </div>
            <div class="feat">
                <div class="feat-icon c">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/><path d="M12 7v5l4 2"/>
                    </svg>
                </div>
                <h3>Track the trip live</h3>
                <p>Real-time location, ETA, and in-app wallet that auto-settles fare splits when the ride ends.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <div class="l-footer">
        <span>&copy; <?= date('Y') ?> RideShare &mdash; Built for enterprise carpooling</span>
        <span style="color:rgba(240,242,245,0.3);">Ride together, save together</span>
    </div>

    <script>
        window.addEventListener('load', () => {
            const p = document.getElementById('landPath');
            if (p) p.style.animation = 'draw 1.5s cubic-bezier(.16,1,.3,1) forwards .3s';
        });

        if (typeof gsap !== 'undefined') {
            const obs = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        gsap.fromTo(e.target, { y: 16, opacity: 0 }, { y: 0, opacity: 1, duration: 0.55, ease: 'power2.out' });
                        obs.unobserve(e.target);
                    }
                });
            }, { threshold: 0.12 });
            document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
        }
    </script>
    <style>@keyframes draw { to { stroke-dashoffset: 0; } }</style>
</body>
</html>
