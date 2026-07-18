<<<<<<< HEAD
# 🚗  — Carpooling Platform (MVC)
=======
# ðŸš— Odoo â€” Enterprise Carpooling Platform (MVC)
>>>>>>> cd0a27e (map integration, route traking, add on extra function on moudules)

> **Team Odoo** | Core PHP 8.2 (MVC) + MySQL + Bootstrap 5 + Vanilla JS + Leaflet.js

Enterprise carpooling platform that enables employees to find and offer rides, manage trips, track journeys in real time, and make secure payments while promoting sustainable commuting. Restructured into a clean MVC architecture to support parallel collaboration across a team of 4 developers.

---

## ðŸ“ Project Structure

```
project/
â”œâ”€â”€ app/
â”‚   â”œâ”€â”€ Controllers/
â”‚   â”‚   â”œâ”€â”€ AuthController.php
â”‚   â”‚   â”œâ”€â”€ RideController.php
â”‚   â”‚   â”œâ”€â”€ VehicleController.php
â”‚   â”‚   â”œâ”€â”€ TripController.php
â”‚   â”‚   â”œâ”€â”€ WalletController.php
â”‚   â”‚   â”œâ”€â”€ PaymentController.php
â”‚   â”‚   â”œâ”€â”€ ReportController.php
â”‚   â”‚   â””â”€â”€ AdminController.php
â”‚   â”œâ”€â”€ Models/
â”‚   â”‚   â”œâ”€â”€ User.php
â”‚   â”‚   â”œâ”€â”€ Vehicle.php
â”‚   â”‚   â”œâ”€â”€ Ride.php
â”‚   â”‚   â”œâ”€â”€ Booking.php
â”‚   â”‚   â”œâ”€â”€ Wallet.php
â”‚   â”‚   â””â”€â”€ Payment.php
â”‚   â”œâ”€â”€ Views/
â”‚   â”‚   â”œâ”€â”€ auth/
â”‚   â”‚   â”œâ”€â”€ rides/
â”‚   â”‚   â”œâ”€â”€ trips/
â”‚   â”‚   â”œâ”€â”€ wallet/
â”‚   â”‚   â”œâ”€â”€ reports/
â”‚   â”‚   â”œâ”€â”€ admin/
â”‚   â”‚   â””â”€â”€ layouts/ (header.php, footer.php, sidebar.php)
â”‚   â”œâ”€â”€ Helpers/
â”‚   â”‚   â”œâ”€â”€ Validator.php
â”‚   â”‚   â”œâ”€â”€ ResponseHelper.php
â”‚   â”‚   â””â”€â”€ GeoHelper.php
â”‚   â”œâ”€â”€ Middleware/
â”‚   â”‚   â”œâ”€â”€ AuthMiddleware.php
â”‚   â”‚   â””â”€â”€ AdminMiddleware.php
â”‚   â”œâ”€â”€ Core/
â”‚   â”‚   â”œâ”€â”€ Router.php
â”‚   â”‚   â”œâ”€â”€ Controller.php (BaseController)
â”‚   â”‚   â”œâ”€â”€ Model.php (BaseModel)
â”‚   â”‚   â””â”€â”€ Database.php (PDO singleton)
â”‚   â”œâ”€â”€ Services/
â”‚   â”‚   â”œâ”€â”€ MapsService.php
â”‚   â”‚   â”œâ”€â”€ RazorpayService.php
â”‚   â”‚   â””â”€â”€ NotificationService.php
â”‚   â””â”€â”€ Config/
â”‚       â””â”€â”€ config.php
â”œâ”€â”€ public/
â”‚   â”œâ”€â”€ assets/
â”‚   â”‚   â”œâ”€â”€ css/
â”‚   â”‚   â”œâ”€â”€ js/
â”‚   â”‚   â””â”€â”€ uploads/
â”‚   â””â”€â”€ index.php   â† single entry point
â”œâ”€â”€ routes/
â”‚   â””â”€â”€ web.php
â”œâ”€â”€ database/
â”‚   â”œâ”€â”€ schema.sql
â”‚   â””â”€â”€ seed.sql
â”œâ”€â”€ storage/
â”‚   â”œâ”€â”€ logs/
â”‚   â””â”€â”€ temp/
â”œâ”€â”€ vendor/          â† autoloader
â”œâ”€â”€ .env
â”œâ”€â”€ composer.json
â””â”€â”€ README.md
```

---

## ðŸš€ Installation & Setup

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

## ðŸ” Demo Login Credentials

| Role | Email | Password |
|------|-------|----------|
| ðŸ§‘ Driver | `driver@Odoo.com` | `password` |
| ðŸ‘© Passenger | `passenger@Odoo.com` | `password` |
| ðŸ‘¤ Admin | `admin@Odoo.com` | `password` |

---

## ðŸ› ï¸ Tech Stack & Integrations
- **Backend:** Core PHP 8.2 (Object-Oriented, MVC)
- **Frontend:** Bootstrap 5, Vanilla JavaScript, Chart.js
- **Map & Routing:** Leaflet.js + OpenStreetMap (via Nominatim & OSRM)
- **Payments:** Razorpay Test Mode integration ready

*Built with â¤ï¸ by Team Odoo*
