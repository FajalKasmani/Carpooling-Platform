<?php
namespace App\Models;

use App\Core\Model;

class Booking extends Model
{
    /**
     * Create a new booking.
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO bookings (ride_id, passenger_id, seats_booked, fare_amount, status)
            VALUES (?, ?, ?, ?, 'booked')
        ");
        $stmt->execute([
            $data['ride_id'],
            $data['passenger_id'],
            $data['seats_booked'],
            $data['fare_amount'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Find booking by ID with full details.
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT b.*,
                   r.pickup_address, r.drop_address, r.travel_date, r.travel_time,
                   r.driver_id, r.vehicle_id, r.fare_per_seat,
                   r.pickup_lat, r.pickup_lng, r.drop_lat, r.drop_lng,
                   u_driver.name AS driver_name, u_driver.phone AS driver_phone,
                   u_pass.name AS passenger_name, u_pass.phone AS passenger_phone,
                   v.model AS vehicle_model, v.registration_number
            FROM bookings b
            JOIN rides r ON r.id = b.ride_id
            JOIN users u_driver ON u_driver.id = r.driver_id
            JOIN users u_pass ON u_pass.id = b.passenger_id
            JOIN vehicles v ON v.id = r.vehicle_id
            WHERE b.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Get all bookings for a passenger.
     */
    public function findByPassenger(int $passengerId): array
    {
        $stmt = $this->db->prepare("
            SELECT b.*, r.pickup_address, r.drop_address, r.travel_date, r.travel_time,
                   r.fare_per_seat, r.driver_id,
                   u.name AS driver_name, u.phone AS driver_phone,
                   v.model AS vehicle_model, v.registration_number
            FROM bookings b
            JOIN rides r ON r.id = b.ride_id
            JOIN users u ON u.id = r.driver_id
            JOIN vehicles v ON v.id = r.vehicle_id
            WHERE b.passenger_id = ?
            ORDER BY r.travel_date DESC, r.travel_time DESC
        ");
        $stmt->execute([$passengerId]);
        return $stmt->fetchAll();
    }

    /**
     * Get all bookings for a ride.
     */
    public function findByRide(int $rideId): array
    {
        $stmt = $this->db->prepare("
            SELECT b.*, u.name AS passenger_name, u.phone AS passenger_phone
            FROM bookings b
            JOIN users u ON u.id = b.passenger_id
            WHERE b.ride_id = ? AND b.status != 'cancelled'
            ORDER BY b.booked_at
        ");
        $stmt->execute([$rideId]);
        return $stmt->fetchAll();
    }

    /**
     * Check if passenger already booked this ride.
     */
    public function alreadyBooked(int $rideId, int $passengerId): bool
    {
        $stmt = $this->db->prepare("
            SELECT 1 FROM bookings
            WHERE ride_id = ? AND passenger_id = ? AND status != 'cancelled'
        ");
        $stmt->execute([$rideId, $passengerId]);
        return (bool)$stmt->fetch();
    }

    /**
     * Update booking status.
     */
    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    /**
     * Bulk update all bookings for a ride (driver starts/ends trip).
     */
    public function updateStatusByRide(int $rideId, string $fromStatus, string $toStatus, array $extraFields = []): bool
    {
        $sets = ["status = ?"];
        $params = [$toStatus];

        if (isset($extraFields['trip_started_at'])) {
            $sets[] = "trip_started_at = ?";
            $params[] = $extraFields['trip_started_at'];
        }
        if (isset($extraFields['trip_completed_at'])) {
            $sets[] = "trip_completed_at = ?";
            $params[] = $extraFields['trip_completed_at'];
        }

        $params[] = $rideId;
        $params[] = $fromStatus;

        $sql = "UPDATE bookings SET " . implode(', ', $sets) . " WHERE ride_id = ? AND status = ?";
        return $this->db->prepare($sql)->execute($params);
    }

    /**
     * Get active trips (for My Trips — both as driver and passenger).
     */
    public function getActiveTrips(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT b.*, r.pickup_address, r.drop_address, r.travel_date, r.travel_time,
                   r.driver_id, r.fare_per_seat,
                   u.name AS driver_name, v.model AS vehicle_model,
                   CASE WHEN r.driver_id = ? THEN 'driver' ELSE 'passenger' END AS user_role
            FROM bookings b
            JOIN rides r ON r.id = b.ride_id
            JOIN users u ON u.id = r.driver_id
            JOIN vehicles v ON v.id = r.vehicle_id
            WHERE (b.passenger_id = ? OR r.driver_id = ?)
              AND b.status IN ('booked','trip_started','trip_in_progress')
            ORDER BY r.travel_date ASC, r.travel_time ASC
        ");
        $stmt->execute([$userId, $userId, $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Get completed trips for Ride History.
     */
    public function getHistory(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT b.*, r.pickup_address, r.drop_address, r.travel_date, r.travel_time,
                   r.driver_id, r.fare_per_seat, r.distance_km,
                   u.name AS driver_name, v.model AS vehicle_model,
                   CASE WHEN r.driver_id = ? THEN 'driver' ELSE 'passenger' END AS user_role
            FROM bookings b
            JOIN rides r ON r.id = b.ride_id
            JOIN users u ON u.id = r.driver_id
            JOIN vehicles v ON v.id = r.vehicle_id
            WHERE (b.passenger_id = ? OR r.driver_id = ?)
              AND b.status IN ('payment_completed','trip_completed','payment_pending')
            ORDER BY r.travel_date DESC, r.travel_time DESC
            LIMIT 50
        ");
        $stmt->execute([$userId, $userId, $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Count bookings for an org (admin).
     */
    public function countByOrg(int $orgId): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM bookings b
            JOIN users u ON u.id = b.passenger_id
            WHERE u.org_id = ?
        ");
        $stmt->execute([$orgId]);
        return (int)$stmt->fetchColumn();
    }
}
