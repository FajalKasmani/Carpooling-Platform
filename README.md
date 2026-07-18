# 🚗 Carpooling Platform

A carpooling platform built using **Core PHP (MVC)**, **MySQL**, **Bootstrap 5**, **Leaflet.js**, and **Razorpay**. The application enables employees to offer rides, search for available rides, manage trips, track journeys in real time, and make secure payments.

---

## ✨ Features

### 🔐 Authentication
- User Registration
- Login & Logout
- Profile Management
- Secure Authentication

### 🚘 Vehicle Management
- Register Vehicles
- Update Vehicle Details
- Manage Multiple Vehicles

### 🚗 Ride Management
- Offer a Ride
- Find Available Rides
- Book Seats
- Cancel Bookings
- View Ride Details

### 📍 Trip Management
- View Upcoming Trips
- Track Trip Status
- Ride History
- Driver & Passenger Details

### 🗺️ Live Trip Tracking
- Interactive Maps
- Route Visualization
- Live Location Tracking
- Estimated Arrival Time (ETA)

### 💳 Wallet & Payments
- Wallet Recharge
- Wallet Balance
- Razorpay Payment Integration
- Payment History

### ⭐ Ratings & Reviews
- Driver Ratings
- Passenger Feedback

### 📊 Reports
- Total Trips
- Distance Travelled
- Travel Statistics
- Cost Analysis

---

# 🛠️ Technology Stack

| Technology | Purpose |
|------------|----------|
| PHP 8.2 | Backend Development |
| MVC Architecture | Application Structure |
| MySQL | Database |
| Bootstrap 5 | User Interface |
| JavaScript | Client-side Functionality |
| Leaflet.js | Interactive Maps |
| OpenStreetMap | Map Tiles |
| OSRM | Route & ETA Calculation |
| Razorpay | Payment Gateway |

---

# 📁 Project Structure

```
Carpooling-Platform/
│
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   ├── Core/
│   ├── Middleware/
│   ├── Services/
│   ├── Helpers/
│   └── Config/
│
├── database/
│   ├── schema.sql
│   └── seed.sql
│
├── public/
│   ├── assets/
│   └── index.php
│
├── routes/
├── storage/
├── vendor/
├── composer.json
├── .env
└── README.md
```

---

# 🗄️ Database

The application uses a normalized relational database to maintain data consistency and reduce redundancy.

### Main Tables

- Organizations
- Users
- Vehicles
- Rides
- Bookings
- Payments
- Wallets
- Wallet Transactions
- Ratings
- Saved Places
- Trip Locations

---

# ⚙️ Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Create Database

Create a MySQL database:

```
carpooling_platform
```

Import:

```
database/schema.sql
database/seed.sql
```

### 4. Configure Environment

Create a `.env` file:

```env
DB_HOST=localhost
DB_NAME=carpooling_platform
DB_USER=root
DB_PASS=
```

### 5. Run the Application

Move the project into the `htdocs` folder.

Start Apache and MySQL using XAMPP.

Open:

```
http://localhost/Carpooling-Platform/public/
```

---

# 👨‍💻 Demo Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@odoo.com | password |
| Employee | employee@odoo.com | password |

---

# 🏗️ Architecture

The project follows the **Model-View-Controller (MVC)** architecture.

- **Models** – Handle database operations.
- **Views** – Display the user interface.
- **Controllers** – Process requests and coordinate between Models and Views.

---

# 🌍 Integrations

- Leaflet.js
- OpenStreetMap
- OSRM Routing API
- Razorpay Test Mode

---
