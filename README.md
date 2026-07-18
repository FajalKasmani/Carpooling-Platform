# 🚗 UDAAN — Enterprise Carpooling Platform (MVC)

> **Team UDAAN** | Core PHP 8.2 (MVC) + MySQL + Bootstrap 5 + Vanilla JS + Leaflet.js

Enterprise carpooling platform that enables employees to find and offer rides, manage trips, track journeys in real time, and make secure payments while promoting sustainable commuting. Restructured into a clean MVC architecture to support parallel collaboration across a team of 4 developers.

---

## 📁 Project Structure

```
project/
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── RideController.php
│   │   ├── VehicleController.php
│   │   ├── TripController.php
│   │   ├── WalletController.php
│   │   ├── PaymentController.php
│   │   ├── ReportController.php
│   │   └── AdminController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Vehicle.php
│   │   ├── Ride.php
│   │   ├── Booking.php
│   │   ├── Wallet.php
│   │   └── Payment.php
│   ├── Views/
│   │   ├── auth/
│   │   ├── rides/
│   │   ├── trips/
│   │   ├── wallet/
│   │   ├── reports/
│   │   ├── admin/
│   │   └── layouts/ (header.php, footer.php, sidebar.php)
│   ├── Helpers/
│   │   ├── Validator.php
│   │   ├── ResponseHelper.php
│   │   └── GeoHelper.php
│   ├── Middleware/
│   │   ├── AuthMiddleware.php
│   │   └── AdminMiddleware.php
│   ├── Core/
│   │   ├── Router.php
│   │   ├── Controller.php (BaseController)
│   │   ├── Model.php (BaseModel)
│   │   └── Database.php (PDO singleton)
│   ├── Services/
│   │   ├── MapsService.php
│   │   ├── RazorpayService.php
│   │   └── NotificationService.php
│   └── Config/
│       └── config.php
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js /
│   │   └── uploads/
│   └── index.php   ← single entry point
├── routes/
│   └── web.php
├── database/
│   ├── schema.sql
│   └── seed.sql
├── storage/
│   ├── logs/
│   └── temp/
├── vendor/          ← autoloader
├── .env
├── composer.json
└── README.md
```

---

## 🚀 Installation & Setup

### 1. Prerequisites
- PHP 8.2+ with PDO MySQL extension
- MySQL 8.x
- Local Web Server (XAMPP / WAMP)

### 2. Move Project to htdocs
Ensure the project is located at `C:/xampp/htdocs/CarPooling`

### 3. Database Initialization
1. Open phpMyAdmin (`http://localhost/phpmyadmin`) or MySQL CLI.
2. Create a database named `carpooling_platform`.
3. Import `database/schema.sql` (schema tables).
4. Import `database/seed.sql` (seed demo users & data).

### 4. Configuration
Duplicate or edit `.env` in the root:
```ini
DB_HOST=localhost
DB_NAME=carpooling_platform
DB_USER=root
DB_PASS=
```

### 5. Launch the Application
Access the app in your browser:
```
http://localhost/CarPooling/
```
Requests are routed to the public front controller (`public/index.php`) via URL rewriting.

---

## 🔐 Demo Login Credentials

| Role | Email | Password |
|------|-------|----------|
| 🧑 Driver | `driver@udaan.com` | `password` |
| 👩 Passenger | `passenger@udaan.com` | `password` |
| 👤 Admin | `admin@udaan.com` | `password` |

---

## 🛠️ Tech Stack & Integrations
- **Backend:** Core PHP 8.2 (Object-Oriented, MVC)
- **Frontend:** Bootstrap 5, Vanilla JavaScript, Chart.js
- **Map & Routing:** Leaflet.js + OpenStreetMap (via Nominatim & OSRM)
- **Payments:** Razorpay Test Mode integration ready

*Built with ❤️ by Team UDAAN*
