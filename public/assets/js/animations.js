/**
 * Odoo — Page Animation Layer
 * Pure progressive enhancement — all functionality works without this file.
 */

document.addEventListener('DOMContentLoaded', () => {

    // ── Sidebar active nav detection ────────────────────────
    const path = window.location.pathname;
    document.querySelectorAll('#sidebar .nav-link').forEach(link => {
        const href = (link.getAttribute('href') || '').split('?')[0];
        if (!href || href === '#') return;
        const segment = href.split('/').pop();
        if (segment && path.endsWith(segment)) {
            link.classList.add('active');
        }
    });

    // ── Mobile bottom nav active ─────────────────────────────
    document.querySelectorAll('#mobile-bottom-nav a').forEach(a => {
        const href = (a.getAttribute('href') || '').split('?')[0];
        if (href && path.endsWith(href.split('/').pop())) {
            a.classList.add('nav-btn-active');
        }
    });

    // ── GSAP page entry animations ───────────────────────────
    if (typeof gsap !== 'undefined') {

        // Cards stagger reveal
        const cards = document.querySelectorAll('.card, .stat-card, .ride-card');
        if (cards.length) {
            gsap.fromTo(cards,
                { y: 16, opacity: 0 },
                { y: 0, opacity: 1, duration: 0.42, stagger: 0.06, ease: 'power2.out', delay: 0.05 }
            );
        }

        // Table rows
        const rows = document.querySelectorAll('tbody tr');
        if (rows.length) {
            gsap.fromTo(rows,
                { x: -10, opacity: 0 },
                { x: 0, opacity: 1, duration: 0.3, stagger: 0.04, ease: 'power2.out', delay: 0.15 }
            );
        }

        // Page heading
        const heading = document.querySelector('h1, h2');
        if (heading) {
            gsap.fromTo(heading,
                { y: -12, opacity: 0 },
                { y: 0, opacity: 1, duration: 0.4, ease: 'power2.out' }
            );
        }
    }

    // ── Stat counter animation ────────────────────────────────
    document.querySelectorAll('[data-count]').forEach(el => {
        const target = parseInt(el.getAttribute('data-count'), 10);
        if (isNaN(target)) return;
        let start = null;
        const duration = 1400;
        const tick = (ts) => {
            if (!start) start = ts;
            const progress = Math.min((ts - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(eased * target).toLocaleString();
            if (progress < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
    });

});
