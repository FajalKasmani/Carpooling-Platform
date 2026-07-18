-- =========================================================
-- Carpooling Platform — Seed / Dummy Data
-- 30 users (28 employees + 2 admins) across 2 organizations,
-- plus supporting vehicles, rides, bookings, wallets,
-- payments, saved places, live locations, and ratings.
-- Run AFTER schema.sql
-- =========================================================

USE carpooling_platform;

SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE ratings;
TRUNCATE TABLE saved_places;
TRUNCATE TABLE payments;
TRUNCATE TABLE wallet_transactions;
TRUNCATE TABLE wallets;
TRUNCATE TABLE trip_locations;
TRUNCATE TABLE bookings;
TRUNCATE TABLE rides;
TRUNCATE TABLE vehicles;
TRUNCATE TABLE users;
TRUNCATE TABLE organizations;

SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------
-- organizations (2)
-- ---------------------------------------------------------
INSERT INTO organizations (id, name, domain, fuel_cost_per_km, default_fare_per_km) VALUES
(1, 'Nova Technologies Pvt Ltd', 'novatech.com', 9.50, 7.00),
(2, 'Bright Finserv Solutions',  'brightfinserv.com', 10.20, 7.50);

-- ---------------------------------------------------------
-- users (30 total: 28 employees + 2 admins)
-- password_hash values below are illustrative bcrypt-style
-- placeholders — replace with real password_hash() output.
-- ---------------------------------------------------------
INSERT INTO users (id, org_id, name, email, phone, password_hash, role, status) VALUES
(1,  1, 'Ananya Rao',        'ananya.rao@novatech.com',       '9876500001', '$2y$10$demoHashPlaceholder0001', 'admin',    'active'),
(2,  1, 'Rohan Mehta',       'rohan.mehta@novatech.com',      '9876500002', '$2y$10$demoHashPlaceholder0002', 'employee', 'active'),
(3,  1, 'Priya Sharma',      'priya.sharma@novatech.com',     '9876500003', '$2y$10$demoHashPlaceholder0003', 'employee', 'active'),
(4,  1, 'Karthik Iyer',      'karthik.iyer@novatech.com',     '9876500004', '$2y$10$demoHashPlaceholder0004', 'employee', 'active'),
(5,  1, 'Sneha Nair',        'sneha.nair@novatech.com',       '9876500005', '$2y$10$demoHashPlaceholder0005', 'employee', 'active'),
(6,  1, 'Arjun Verma',       'arjun.verma@novatech.com',      '9876500006', '$2y$10$demoHashPlaceholder0006', 'employee', 'active'),
(7,  1, 'Divya Menon',       'divya.menon@novatech.com',      '9876500007', '$2y$10$demoHashPlaceholder0007', 'employee', 'active'),
(8,  1, 'Vikram Singh',      'vikram.singh@novatech.com',     '9876500008', '$2y$10$demoHashPlaceholder0008', 'employee', 'active'),
(9,  1, 'Neha Kulkarni',     'neha.kulkarni@novatech.com',    '9876500009', '$2y$10$demoHashPlaceholder0009', 'employee', 'active'),
(10, 1, 'Aditya Desai',      'aditya.desai@novatech.com',     '9876500010', '$2y$10$demoHashPlaceholder0010', 'employee', 'active'),
(11, 1, 'Kavya Reddy',       'kavya.reddy@novatech.com',      '9876500011', '$2y$10$demoHashPlaceholder0011', 'employee', 'active'),
(12, 1, 'Manish Gupta',      'manish.gupta@novatech.com',     '9876500012', '$2y$10$demoHashPlaceholder0012', 'employee', 'active'),
(13, 1, 'Ritika Joshi',      'ritika.joshi@novatech.com',     '9876500013', '$2y$10$demoHashPlaceholder0013', 'employee', 'active'),
(14, 1, 'Suresh Pillai',     'suresh.pillai@novatech.com',    '9876500014', '$2y$10$demoHashPlaceholder0014', 'employee', 'inactive'),
(15, 1, 'Anjali Bhatt',      'anjali.bhatt@novatech.com',     '9876500015', '$2y$10$demoHashPlaceholder0015', 'employee', 'active'),
(16, 2, 'Farhan Khan',       'farhan.khan@brightfinserv.com', '9876500016', '$2y$10$demoHashPlaceholder0016', 'admin',    'active'),
(17, 2, 'Meera Pillai',      'meera.pillai@brightfinserv.com','9876500017', '$2y$10$demoHashPlaceholder0017', 'employee', 'active'),
(18, 2, 'Siddharth Rao',     'siddharth.rao@brightfinserv.com','9876500018','$2y$10$demoHashPlaceholder0018', 'employee', 'active'),
(19, 2, 'Pooja Agarwal',     'pooja.agarwal@brightfinserv.com','9876500019','$2y$10$demoHashPlaceholder0019', 'employee', 'active'),
(20, 2, 'Nikhil Chatterjee', 'nikhil.c@brightfinserv.com',    '9876500020', '$2y$10$demoHashPlaceholder0020', 'employee', 'active'),
(21, 2, 'Sanya Kapoor',      'sanya.kapoor@brightfinserv.com','9876500021', '$2y$10$demoHashPlaceholder0021', 'employee', 'active'),
(22, 2, 'Rahul Bose',        'rahul.bose@brightfinserv.com',  '9876500022', '$2y$10$demoHashPlaceholder0022', 'employee', 'active'),
(23, 2, 'Ishita Sen',        'ishita.sen@brightfinserv.com',  '9876500023', '$2y$10$demoHashPlaceholder0023', 'employee', 'active'),
(24, 2, 'Aman Tripathi',     'aman.tripathi@brightfinserv.com','9876500024','$2y$10$demoHashPlaceholder0024', 'employee', 'active'),
(25, 2, 'Deepika Suresh',    'deepika.s@brightfinserv.com',   '9876500025', '$2y$10$demoHashPlaceholder0025', 'employee', 'active'),
(26, 2, 'Varun Malhotra',    'varun.m@brightfinserv.com',     '9876500026', '$2y$10$demoHashPlaceholder0026', 'employee', 'active'),
(27, 2, 'Shreya Iyengar',    'shreya.i@brightfinserv.com',    '9876500027', '$2y$10$demoHashPlaceholder0027', 'employee', 'active'),
(28, 2, 'Harsh Vardhan',     'harsh.v@brightfinserv.com',     '9876500028', '$2y$10$demoHashPlaceholder0028', 'employee', 'active'),
(29, 2, 'Tanvi Kulkarni',    'tanvi.k@brightfinserv.com',     '9876500029', '$2y$10$demoHashPlaceholder0029', 'employee', 'inactive'),
(30, 2, 'Yash Malhotra',     'yash.malhotra@brightfinserv.com','9876500030','$2y$10$demoHashPlaceholder0030', 'employee', 'active');

-- ---------------------------------------------------------
-- vehicles (10 — owned by a subset of employees who drive)
-- ---------------------------------------------------------
INSERT INTO vehicles (id, owner_id, model, registration_number, seating_capacity, status) VALUES
(1,  2,  'Honda City',       'KA01AB1234', 4, 'active'),
(2,  4,  'Maruti Swift',     'KA01AC5678', 4, 'active'),
(3,  6,  'Hyundai Creta',    'KA01AD9012', 5, 'active'),
(4,  8,  'Toyota Innova',    'KA01AE3456', 6, 'active'),
(5,  10, 'Tata Nexon',       'KA01AF7890', 4, 'active'),
(6,  17, 'Honda Amaze',      'WB02BX1122', 4, 'active'),
(7,  19, 'Maruti Baleno',    'WB02BY3344', 4, 'active'),
(8,  22, 'Kia Seltos',       'WB02BZ5566', 5, 'active'),
(9,  24, 'Mahindra XUV300',  'WB02CA7788', 4, 'active'),
(10, 26, 'Hyundai Verna',    'WB02CB9900', 4, 'active');

-- ---------------------------------------------------------
-- rides (8 — mix of upcoming/published and demo-active)
-- ---------------------------------------------------------
INSERT INTO rides (id, driver_id, vehicle_id, pickup_address, pickup_lat, pickup_lng,
                    drop_address, drop_lat, drop_lng, travel_date, travel_time,
                    available_seats, total_seats, fare_per_seat, is_recurring, status) VALUES
(1, 2,  1, 'Indiranagar, Bengaluru',   12.9716, 77.6412, 'Novatech Campus, Whitefield', 12.9698, 77.7500, '2026-07-20', '09:00:00', 2, 3, 85.00, 0, 'published'),
(2, 4,  2, 'Koramangala, Bengaluru',   12.9352, 77.6146, 'Novatech Campus, Whitefield', 12.9698, 77.7500, '2026-07-20', '08:45:00', 2, 3, 90.00, 1, 'published'),
(3, 6,  3, 'HSR Layout, Bengaluru',    12.9121, 77.6446, 'Novatech Campus, Whitefield', 12.9698, 77.7500, '2026-07-21', '09:15:00', 2, 4, 75.00, 0, 'published'),
(4, 8,  4, 'Electronic City, Bengaluru', 12.8452, 77.6602, 'Novatech Campus, Whitefield', 12.9698, 77.7500, '2026-07-19', '08:30:00', 0, 5, 95.00, 0, 'full'),
(5, 10, 5, 'Marathahalli, Bengaluru',  12.9569, 77.7011, 'Novatech Campus, Whitefield', 12.9698, 77.7500, '2026-07-18', '08:50:00', 2, 3, 60.00, 0, 'published'),
(6, 17, 6, 'Salt Lake, Kolkata',       22.5727, 88.4310, 'Bright Finserv Tower, Sector V', 22.5697, 88.4297, '2026-07-20', '09:00:00', 3, 4, 65.00, 1, 'published'),
(7, 19, 7, 'New Town, Kolkata',        22.5809, 88.4650, 'Bright Finserv Tower, Sector V', 22.5697, 88.4297, '2026-07-20', '09:10:00', 2, 3, 55.00, 0, 'published'),
(8, 22, 8, 'Park Street, Kolkata',     22.5535, 88.3527, 'Bright Finserv Tower, Sector V', 22.5697, 88.4297, '2026-07-17', '08:40:00', 0, 4, 70.00, 0, 'expired');

-- ---------------------------------------------------------
-- bookings (8 — spread across the trip lifecycle)
-- ---------------------------------------------------------
INSERT INTO bookings (id, ride_id, passenger_id, seats_booked, fare_amount, status, booked_at, trip_started_at, trip_completed_at) VALUES
(1, 1, 3,  1, 85.00,  'booked',            '2026-07-18 10:00:00', NULL, NULL),
(2, 2, 5,  1, 90.00,  'booked',            '2026-07-18 10:05:00', NULL, NULL),
(3, 3, 7,  2, 150.00, 'booked',            '2026-07-18 11:00:00', NULL, NULL),
(4, 4, 9,  2, 190.00, 'trip_completed',    '2026-07-17 08:00:00', '2026-07-19 08:32:00', '2026-07-19 09:05:00'),
(5, 4, 11, 3, 285.00, 'payment_completed', '2026-07-17 08:10:00', '2026-07-19 08:32:00', '2026-07-19 09:05:00'),
(6, 5, 13, 1, 60.00,  'trip_in_progress',  '2026-07-18 07:30:00', '2026-07-18 08:52:00', NULL),
(7, 6, 20, 1, 65.00,  'booked',            '2026-07-18 09:00:00', NULL, NULL),
(8, 8, 23, 4, 280.00, 'payment_completed', '2026-07-16 08:00:00', '2026-07-17 08:42:00', '2026-07-17 09:15:00');

-- ---------------------------------------------------------
-- trip_locations (3 — only for rides currently active/recent)
-- ---------------------------------------------------------
INSERT INTO trip_locations (id, ride_id, current_lat, current_lng, eta_minutes) VALUES
(1, 5, 12.9601, 77.7203, 8),
(2, 4, 12.9698, 77.7500, 0),
(3, 8, 22.5697, 88.4297, 0);

-- ---------------------------------------------------------
-- wallets (one per user who has transacted — 10 sample)
-- ---------------------------------------------------------
INSERT INTO wallets (id, user_id, balance) VALUES
(1, 3,  250.00),
(2, 5,  120.00),
(3, 7,  340.50),
(4, 9,  0.00),
(5, 11, 415.00),
(6, 13, 90.00),
(7, 20, 200.00),
(8, 23, 55.00),
(9, 2,  500.00),
(10, 17, 175.25);

-- ---------------------------------------------------------
-- wallet_transactions (12 — recharges and debits)
-- ---------------------------------------------------------
INSERT INTO wallet_transactions (id, wallet_id, type, amount, reference, created_at) VALUES
(1,  1, 'recharge', 500.00, 'pay_test_rzp_0001', '2026-07-10 09:00:00'),
(2,  1, 'debit',    250.00, 'booking_ref_0001',  '2026-07-12 09:30:00'),
(3,  2, 'recharge', 200.00, 'pay_test_rzp_0002', '2026-07-11 10:00:00'),
(4,  2, 'debit',    80.00,  'booking_ref_0002',  '2026-07-13 11:00:00'),
(5,  3, 'recharge', 400.00, 'pay_test_rzp_0003', '2026-07-09 08:00:00'),
(6,  3, 'debit',    59.50,  'booking_ref_0003',  '2026-07-14 08:45:00'),
(7,  5, 'recharge', 500.00, 'pay_test_rzp_0004', '2026-07-08 09:00:00'),
(8,  5, 'debit',    85.00,  'booking_ref_0004',  '2026-07-17 09:05:00'),
(9,  9, 'recharge', 500.00, 'pay_test_rzp_0005', '2026-07-07 12:00:00'),
(10, 10, 'recharge', 200.00, 'pay_test_rzp_0006', '2026-07-15 12:30:00'),
(11, 10, 'debit',    24.75,  'booking_ref_0005',  '2026-07-16 12:45:00'),
(12, 6, 'recharge',  90.00,  'pay_test_rzp_0007', '2026-07-16 13:00:00');

-- ---------------------------------------------------------
-- payments (6 — one per completed/pending booking)
-- ---------------------------------------------------------
INSERT INTO payments (id, booking_id, amount, method, razorpay_payment_id, status, paid_at) VALUES
(1, 4, 190.00, 'upi',    'pay_test_9AbC1234', 'success', '2026-07-19 09:10:00'),
(2, 5, 285.00, 'wallet', NULL,                 'success', '2026-07-19 09:12:00'),
(3, 8, 280.00, 'card',   'pay_test_9AbC5678', 'success', '2026-07-17 09:20:00'),
(4, 6, 60.00,  'cash',   NULL,                 'pending', NULL),
(5, 1, 85.00,  'wallet', NULL,                 'pending', NULL),
(6, 3, 150.00, 'upi',    'pay_test_9AbC9012', 'pending', NULL);

-- ---------------------------------------------------------
-- saved_places (6)
-- ---------------------------------------------------------
INSERT INTO saved_places (id, user_id, label, address, lat, lng) VALUES
(1, 3,  'Home',   'JP Nagar, Bengaluru',      12.9077, 77.5850),
(2, 3,  'Office', 'Novatech Campus, Whitefield', 12.9698, 77.7500),
(3, 5,  'Home',   'BTM Layout, Bengaluru',    12.9166, 77.6101),
(4, 20, 'Home',   'Rajarhat, Kolkata',        22.6157, 88.4423),
(5, 23, 'Home',   'Ballygunge, Kolkata',      22.5273, 88.3648),
(6, 23, 'Office', 'Bright Finserv Tower, Sector V', 22.5697, 88.4297);

-- ---------------------------------------------------------
-- ratings (5 — for completed bookings)
-- ---------------------------------------------------------
INSERT INTO ratings (id, booking_id, rated_by, rated_user, rating, comment) VALUES
(1, 4, 9,  8,  5, 'Smooth ride, on time pickup.'),
(2, 4, 8,  9,  4, 'Good, polite passenger.'),
(3, 5, 11, 8,  5, 'Very comfortable, would ride again.'),
(4, 8, 23, 22, 4, 'Driver was courteous and safe.'),
(5, 8, 22, 23, 5, 'Punctual passenger, easy trip.');
