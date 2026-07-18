-- =========================================================
-- Carpooling Platform — Database Schema
-- MySQL 8.x / InnoDB
-- =========================================================

CREATE DATABASE IF NOT EXISTS carpooling_platform
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE carpooling_platform;

SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------
-- organizations
-- ---------------------------------------------------------
DROP TABLE IF EXISTS organizations;
CREATE TABLE organizations (
    id                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name                  VARCHAR(150) NOT NULL,
    domain                VARCHAR(150) NOT NULL UNIQUE,
    fuel_cost_per_km      DECIMAL(6,2) NOT NULL DEFAULT 10.00,
    default_fare_per_km   DECIMAL(6,2) NOT NULL DEFAULT 8.00,
    created_at            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- users  (employee is both driver & passenger — see notes)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    org_id          INT UNSIGNED NOT NULL,
    name            VARCHAR(100) NOT NULL,
    email           VARCHAR(150) NOT NULL UNIQUE,
    phone           VARCHAR(15) NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,
    role            ENUM('employee','admin') NOT NULL DEFAULT 'employee',
    profile_photo   VARCHAR(255) NULL,
    status          ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_org FOREIGN KEY (org_id) REFERENCES organizations(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- vehicles
-- ---------------------------------------------------------
DROP TABLE IF EXISTS vehicles;
CREATE TABLE vehicles (
    id                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    owner_id              INT UNSIGNED NOT NULL,
    model                 VARCHAR(100) NOT NULL,
    registration_number   VARCHAR(20) NOT NULL UNIQUE,
    seating_capacity      TINYINT UNSIGNED NOT NULL,
    status                ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_vehicles_owner FOREIGN KEY (owner_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- rides
-- ---------------------------------------------------------
DROP TABLE IF EXISTS rides;
CREATE TABLE rides (
    id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    driver_id         INT UNSIGNED NOT NULL,
    vehicle_id        INT UNSIGNED NOT NULL,
    pickup_address    VARCHAR(255) NOT NULL,
    pickup_lat        DECIMAL(10,7) NOT NULL,
    pickup_lng        DECIMAL(10,7) NOT NULL,
    drop_address      VARCHAR(255) NOT NULL,
    drop_lat          DECIMAL(10,7) NOT NULL,
    drop_lng          DECIMAL(10,7) NOT NULL,
    route_polyline    TEXT NULL,
    travel_date       DATE NOT NULL,
    travel_time       TIME NOT NULL,
    available_seats   TINYINT UNSIGNED NOT NULL,
    total_seats       TINYINT UNSIGNED NOT NULL,
    fare_per_seat     DECIMAL(8,2) NOT NULL,
    is_recurring      BOOLEAN NOT NULL DEFAULT FALSE,
    status            ENUM('published','full','cancelled','expired') NOT NULL DEFAULT 'published',
    created_at        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_rides_driver  FOREIGN KEY (driver_id)  REFERENCES users(id)    ON DELETE CASCADE,
    CONSTRAINT fk_rides_vehicle FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE,
    INDEX idx_rides_search (travel_date, status)
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- bookings  (also the trip-lifecycle source of truth)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS bookings;
CREATE TABLE bookings (
    id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ride_id             INT UNSIGNED NOT NULL,
    passenger_id        INT UNSIGNED NOT NULL,
    seats_booked        TINYINT UNSIGNED NOT NULL,
    fare_amount         DECIMAL(8,2) NOT NULL,
    status              ENUM('booked','trip_started','trip_in_progress','trip_completed',
                              'payment_pending','payment_completed','cancelled')
                        NOT NULL DEFAULT 'booked',
    booked_at           TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    trip_started_at     TIMESTAMP NULL,
    trip_completed_at   TIMESTAMP NULL,
    CONSTRAINT fk_bookings_ride      FOREIGN KEY (ride_id)      REFERENCES rides(id) ON DELETE CASCADE,
    CONSTRAINT fk_bookings_passenger FOREIGN KEY (passenger_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- trip_locations  (latest GPS ping only — overwrite pattern)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS trip_locations;
CREATE TABLE trip_locations (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ride_id       INT UNSIGNED NOT NULL UNIQUE,
    current_lat   DECIMAL(10,7) NOT NULL,
    current_lng   DECIMAL(10,7) NOT NULL,
    eta_minutes   SMALLINT UNSIGNED NULL,
    updated_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_triploc_ride FOREIGN KEY (ride_id) REFERENCES rides(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- wallets
-- ---------------------------------------------------------
DROP TABLE IF EXISTS wallets;
CREATE TABLE wallets (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id      INT UNSIGNED NOT NULL UNIQUE,
    balance      DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    updated_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_wallets_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- wallet_transactions  (append-only ledger)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS wallet_transactions;
CREATE TABLE wallet_transactions (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    wallet_id    INT UNSIGNED NOT NULL,
    type         ENUM('recharge','debit') NOT NULL,
    amount       DECIMAL(10,2) NOT NULL,
    reference    VARCHAR(100) NULL,
    created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_wallettx_wallet FOREIGN KEY (wallet_id) REFERENCES wallets(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- payments
-- ---------------------------------------------------------
DROP TABLE IF EXISTS payments;
CREATE TABLE payments (
    id                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id            INT UNSIGNED NOT NULL,
    amount                DECIMAL(8,2) NOT NULL,
    method                ENUM('cash','card','upi','wallet') NOT NULL,
    razorpay_payment_id   VARCHAR(100) NULL,
    status                ENUM('pending','success','failed') NOT NULL DEFAULT 'pending',
    paid_at               TIMESTAMP NULL,
    CONSTRAINT fk_payments_booking FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- saved_places
-- ---------------------------------------------------------
DROP TABLE IF EXISTS saved_places;
CREATE TABLE saved_places (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    INT UNSIGNED NOT NULL,
    label      VARCHAR(50) NOT NULL,
    address    VARCHAR(255) NOT NULL,
    lat        DECIMAL(10,7) NOT NULL,
    lng        DECIMAL(10,7) NOT NULL,
    CONSTRAINT fk_savedplaces_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- ratings  (bonus)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS ratings;
CREATE TABLE ratings (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id   INT UNSIGNED NOT NULL,
    rated_by     INT UNSIGNED NOT NULL,
    rated_user   INT UNSIGNED NOT NULL,
    rating       TINYINT UNSIGNED NOT NULL,
    comment      VARCHAR(255) NULL,
    CONSTRAINT fk_ratings_booking    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    CONSTRAINT fk_ratings_rated_by   FOREIGN KEY (rated_by)   REFERENCES users(id)    ON DELETE CASCADE,
    CONSTRAINT fk_ratings_rated_user FOREIGN KEY (rated_user) REFERENCES users(id)    ON DELETE CASCADE,
    CONSTRAINT chk_rating_range CHECK (rating BETWEEN 1 AND 5)
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;
