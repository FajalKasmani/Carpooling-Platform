-- ============================================================
-- UDAAN Carpooling Platform — Seed Data
-- Demo org, 5 users, 2 vehicles, 4 rides, sample bookings
-- ============================================================

USE `carpooling_platform`;

-- ── Organization ──────────────────────────────────────────
INSERT INTO `organizations` (`id`, `name`, `domain`, `fuel_cost_per_km`, `default_fare_per_km`)
VALUES (1, 'UDAAN Demo Org', 'udaan.com', 10.00, 8.00)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- ── Users (password = 'password' for all) ─────────────────
-- bcrypt hash of 'password': $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
INSERT INTO `users` (`id`, `org_id`, `name`, `email`, `phone`, `password_hash`, `role`, `status`) VALUES
(1, 1, 'Arjun Mehta',    'driver@udaan.com',    '9876543210', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employee', 'active'),
(2, 1, 'Priya Sharma',   'passenger@udaan.com', '9123456789', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employee', 'active'),
(3, 1, 'Admin UDAAN',    'admin@udaan.com',     '9000000001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin',    'active'),
(4, 1, 'Rahul Verma',    'rahul@udaan.com',     '9876500001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employee', 'active'),
(5, 1, 'Sneha Patel',    'sneha@udaan.com',     '9876500002', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employee', 'active')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- ── Vehicles ──────────────────────────────────────────────
INSERT INTO `vehicles` (`id`, `owner_id`, `model`, `registration_number`, `seating_capacity`, `status`) VALUES
(1, 1, 'Honda City',      'GJ01AB1234', 5, 'active'),
(2, 4, 'Maruti Swift',    'GJ05CD5678', 5, 'active')
ON DUPLICATE KEY UPDATE `model` = VALUES(`model`);

-- ── Wallets ───────────────────────────────────────────────
INSERT INTO `wallets` (`user_id`, `balance`) VALUES
(1, 1200.00),
(2,  850.00),
(3,  500.00),
(4, 1000.00),
(5,  750.00)
ON DUPLICATE KEY UPDATE `balance` = VALUES(`balance`);

-- ── Rides (future dates — adjust if needed) ───────────────
INSERT INTO `rides` (`id`, `driver_id`, `vehicle_id`, `pickup_address`, `pickup_lat`, `pickup_lng`, `drop_address`, `drop_lat`, `drop_lng`, `travel_date`, `travel_time`, `available_seats`, `total_seats`, `fare_per_seat`, `distance_km`, `status`) VALUES
(1, 1, 1, 'ISKCON Temple, Ahmedabad',  23.0275, 72.5071, 'Infocity, Gandhinagar',       23.1882, 72.6283, CURDATE() + INTERVAL 1 DAY, '09:00:00', 3, 4, 120.00, 22.5, 'published'),
(2, 1, 1, 'Satellite Road, Ahmedabad', 23.0195, 72.5270, 'Science City, Ahmedabad',     23.0727, 72.5115, CURDATE() + INTERVAL 1 DAY, '08:30:00', 2, 4, 80.00,  8.0,  'published'),
(3, 4, 2, 'Maninagar, Ahmedabad',      23.0028, 72.6015, 'Naroda GIDC, Ahmedabad',      23.0746, 72.6583, CURDATE() + INTERVAL 2 DAY, '09:15:00', 3, 4, 60.00,  12.0, 'published'),
(4, 4, 2, 'SG Highway, Ahmedabad',     23.0454, 72.4990, 'Gandhinagar Secretariat',     23.2156, 72.6369, CURDATE() + INTERVAL 2 DAY, '08:00:00', 1, 4, 150.00, 35.0, 'published')
ON DUPLICATE KEY UPDATE `status` = VALUES(`status`);

-- ── Sample Booking ────────────────────────────────────────
INSERT INTO `bookings` (`ride_id`, `passenger_id`, `seats_booked`, `fare_amount`, `status`) VALUES
(1, 2, 1, 120.00, 'booked')
ON DUPLICATE KEY UPDATE `status` = VALUES(`status`);

-- ── Wallet Transactions ───────────────────────────────────
INSERT INTO `wallet_transactions` (`wallet_id`, `type`, `amount`, `reference`) VALUES
(1, 'recharge', 1200.00, 'initial_seed'),
(2, 'recharge',  850.00, 'initial_seed'),
(3, 'recharge',  500.00, 'initial_seed');
