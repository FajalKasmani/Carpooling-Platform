# 🚗 UDAAN — Smart Carpooling Platform

> **Team UDAAN** | Hackathon MVP | PHP + MySQL + Vanilla JS + Tailwind CSS

Enterprise carpooling platform that enables employees to find and offer rides, manage trips, track journeys in real time, and make secure payments while promoting sustainable commuting.

---

## 🚀 Quick Start

### 1. Prerequisites
- PHP 8.0+ with PDO MySQL extension
- MySQL 8.x
- A local web server (XAMPP / WAMP / Laragon)

### 2. Setup Database
```bash
# Place project in your web server's root (e.g., htdocs/CarPooling)
# Then open in browser:
http://localhost/CarPooling/setup.php
```
This will:
- Run `database/schema.sql` (team's full schema)
- Run `database/seed.sql` (team's 30 demo users)
- Add UDAAN demo users with real bcrypt passwords

### 3. Configure Database
Edit `config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');    // your MySQL user
define('DB_PASS', '');        // your MySQL password
```

### 4. Launch the App
```
http://localhost/CarPooling/index.html
```

---

## 🔐 Demo Login Credentials

| Role | Email | Password |
|------|-------|----------|
| 🧑 Driver | `driver@udaan.com` | `password` |
| 👩 Passenger | `passenger@udaan.com` | `password` |
| 👤 Admin | `admin@udaan.com` | `password` |

---

## 📁 Project Structure

```
CarPooling/
├── index.html              ← Full SPA Dashboard (Tailwind CSS + Leaflet.js)
├── config.php              ← Database connection (PDO)
├── setup.php               ← One-click DB setup + seed
├── .gitignore
│
├── api/                    ← PHP JSON API endpoints
│   ├── auth.php            ← Login / logout / session check
│   ├── get_rides.php       ← Fetch available rides
│   ├── book_ride.php       ← Book a ride (wallet deduction)
│   ├── offer_ride.php      ← Driver publishes new ride
│   ├── my_trips.php        ← Passenger's booking history
│   └── wallet.php          ← Wallet balance & top-up
│
└── database/               ← Team's SQL files
    ├── schema.sql           ← Full database schema (team)
    └── seed.sql             ← 30 demo users + data (team)
```

---

## 🎯 Features

| Feature | Status |
|---------|--------|
| 🔐 Login / Session auth | ✅ |
| 🔍 Find & search rides | ✅ |
| 🚗 Book a ride (wallet deduction) | ✅ |
| ➕ Offer / publish a ride | ✅ |
| 🧳 My trips history | ✅ |
| 📍 Live tracking (Leaflet.js map) | ✅ |
| 💳 Wallet with QR recharge | ✅ |
| 📱 Mobile responsive | ✅ |
| 🌿 CO₂ savings tracker | ✅ |
| ⚡ Offline demo mode | ✅ |

---

## 🛠️ Tech Stack

- **Frontend:** HTML5, Tailwind CSS (CDN), Vanilla JavaScript
- **Map:** Leaflet.js + OpenStreetMap (no API key needed)
- **Backend:** PHP 8+ (Procedural + PDO)
- **Database:** MySQL 8.x (InnoDB)

---

*Built with ❤️ by Team UDAAN*
