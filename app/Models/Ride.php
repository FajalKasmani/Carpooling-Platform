<?php
namespace App\Models;

use App\Core\Model;
use App\Helpers\GeoHelper;

class Ride extends Model
{
    /**
     * Create a new ride (Offer Ride).
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO rides (
                driver_id, vehicle_id, pickup_address, pickup_lat, pickup_lng,
                drop_address, drop_lat, drop_lng, route_polyline,
                travel_date, travel_time, available_seats, total_seats,
                fare_per_seat, distance_km, is_recurring
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $seats = $data['available_seats'];
        $stmt->execute([
            $data['driver_id'],
            $data['vehicle_id'],
            $data['pickup_address'],
            $data['pickup_lat']  ?? null,
            $data['pickup_lng']  ?? null,
            $data['drop_address'],
            $data['drop_lat']    ?? null,
            $data['drop_lng']    ?? null,
            $data['route_polyline'] ?? null,
            $data['travel_date'],
            $data['travel_time'],
            $seats,
            $seats,
            $data['fare_per_seat'],
            $data['distance_km'] ?? null,
            $data['is_recurring'] ?? false,
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Find ride by ID.
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT r.*, u.name AS driver_name, u.phone AS driver_phone,
                   u.profile_photo AS driver_photo,
                   v.model AS vehicle_model, v.registration_number,
                   v.seating_capacity
            FROM rides r
            JOIN users u ON u.id = r.driver_id
            JOIN vehicles v ON v.id = r.vehicle_id
            WHERE r.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Search for matching rides (Find Ride).
     */
    public function search(array $filters): array
    {
        $sql = "
            SELECT r.*, u.name AS driver_name, u.phone AS driver_phone,
                   v.model AS vehicle_model, v.registration_number
            FROM rides r
            JOIN users u ON u.id = r.driver_id
            JOIN vehicles v ON v.id = r.vehicle_id
            WHERE r.status = 'published'
              AND r.available_seats >= ?
              AND r.travel_date = ?
              AND u.status = 'active'
        ";
        $params = [
            $filters['seats'] ?? 1,
            $filters['travel_date'],
        ];

        // Time window filter (±1 hour)
        if (!empty($filters['travel_time'])) {
            $sql .= " AND ABS(TIME_TO_SEC(TIMEDIFF(r.travel_time, ?))) <= 3600";
            $params[] = $filters['travel_time'];
        }

        $sql .= " ORDER BY ABS(TIME_TO_SEC(TIMEDIFF(r.travel_time, ?))) ASC, r.fare_per_seat ASC LIMIT 50";
        $params[] = $filters['travel_time'] ?? '09:00:00';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rides = $stmt->fetchAll();

        // Post-filter by geo-proximity if lat/lng provided
        if (!empty($filters['pickup_lat']) && !empty($filters['drop_lat'])) {
            $rides = array_filter($rides, function ($ride) use ($filters) {
                if (!$ride['pickup_lat'] || !$ride['drop_lat']) return true; // no geo data, include by default

                $pickupClose = GeoHelper::isWithinRadius(
                    (float)$filters['pickup_lat'], (float)$filters['pickup_lng'],
                    (float)$ride['pickup_lat'], (float)$ride['pickup_lng'],
                    5.0 // 5km radius
                );
                $dropClose = GeoHelper::isWithinRadius(
                    (float)$filters['drop_lat'], (float)$filters['drop_lng'],
                    (float)$ride['drop_lat'], (float)$ride['drop_lng'],
                    5.0
                );
                return $pickupClose && $dropClose;
            });
            $rides = array_values($rides);
        }

        // Add driver rating average
        foreach ($rides as &$ride) {
            $rStmt = $this->db->prepare("
                SELECT COALESCE(AVG(rt.rating), 0) AS avg_rating
                FROM ratings rt
                JOIN bookings b ON b.id = rt.booking_id
                JOIN rides ri ON ri.id = b.ride_id
                WHERE ri.driver_id = ?
            ");
            $rStmt->execute([$ride['driver_id']]);
            $ride['driver_rating'] = round((float)$rStmt->fetchColumn(), 1);
        }
        unset($ride);

        return $rides;
    }

    /**
     * Decrement available seats (within a transaction).
     */
    public function decrementSeats(int $rideId, int $count = 1): bool
    {
        $stmt = $this->db->prepare("
            UPDATE rides SET available_seats = available_seats - ?
            WHERE id = ? AND available_seats >= ?
        ");
        $stmt->execute([$count, $rideId, $count]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Update ride status.
     */
    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE rides SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    /**
     * Get rides offered by a driver.
     */
    public function getByDriverId(int $driverId): array
    {
        $stmt = $this->db->prepare("
            SELECT r.*, v.model AS vehicle_model,
                   (SELECT COUNT(*) FROM bookings b WHERE b.ride_id = r.id AND b.status != 'cancelled') AS booked_seats
            FROM rides r
            JOIN vehicles v ON v.id = r.vehicle_id
            WHERE r.driver_id = ?
            ORDER BY r.travel_date DESC, r.travel_time DESC
        ");
        $stmt->execute([$driverId]);
        return $stmt->fetchAll();
    }

    /**
     * Find ride with lock for booking (race condition prevention).
     */
    public function findForBooking(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM rides WHERE id = ? AND status = 'published' FOR UPDATE
        ");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Count rides for an org (admin).
     */
    public function countByOrg(int $orgId): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM rides r
            JOIN users u ON u.id = r.driver_id
            WHERE u.org_id = ?
        ");
        $stmt->execute([$orgId]);
        return (int)$stmt->fetchColumn();
    }
}
