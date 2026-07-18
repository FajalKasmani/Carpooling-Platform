<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Booking;

class ReportController extends Controller
{
    /**
     * Personal reports page.
     * GET /reports
     */
    public function index(): void
    {
        $this->view('reports/index', [
            'flash' => $this->getFlash(),
        ]);
    }

    /**
     * Personal summary (AJAX).
     * GET /reports/summary
     */
    public function summary(): void
    {
        $userId = $this->userId();
        $db     = Database::getConnection();

        // Total trips as passenger
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM bookings
            WHERE passenger_id = ? AND status IN ('trip_completed','payment_completed','payment_pending')
        ");
        $stmt->execute([$userId]);
        $totalAsPassenger = (int)$stmt->fetchColumn();

        // Total trips as driver
        $stmt = $db->prepare("
            SELECT COUNT(DISTINCT r.id) FROM rides r
            JOIN bookings b ON b.ride_id = r.id
            WHERE r.driver_id = ? AND b.status IN ('trip_completed','payment_completed','payment_pending')
        ");
        $stmt->execute([$userId]);
        $totalAsDriver = (int)$stmt->fetchColumn();

        // Total distance
        $stmt = $db->prepare("
            SELECT COALESCE(SUM(r.distance_km), 0) FROM bookings b
            JOIN rides r ON r.id = b.ride_id
            WHERE (b.passenger_id = ? OR r.driver_id = ?)
              AND b.status IN ('trip_completed','payment_completed')
        ");
        $stmt->execute([$userId, $userId]);
        $totalDistance = (float)$stmt->fetchColumn();

        // Total money spent (as passenger)
        $stmt = $db->prepare("
            SELECT COALESCE(SUM(fare_amount), 0) FROM bookings
            WHERE passenger_id = ? AND status IN ('payment_completed')
        ");
        $stmt->execute([$userId]);
        $totalSpent = (float)$stmt->fetchColumn();

        // Total money earned (as driver)
        $stmt = $db->prepare("
            SELECT COALESCE(SUM(b.fare_amount), 0) FROM bookings b
            JOIN rides r ON r.id = b.ride_id
            WHERE r.driver_id = ? AND b.status IN ('payment_completed')
        ");
        $stmt->execute([$userId]);
        $totalEarned = (float)$stmt->fetchColumn();

        // CO₂ saved estimate (avg car = 120g/km, sharing saves ~50%)
        $co2Saved = round($totalDistance * 0.06, 2); // kg

        // Monthly breakdown (last 6 months)
        $stmt = $db->prepare("
            SELECT DATE_FORMAT(r.travel_date, '%Y-%m') AS month,
                   COUNT(*) AS trips,
                   COALESCE(SUM(r.distance_km), 0) AS distance,
                   COALESCE(SUM(b.fare_amount), 0) AS cost
            FROM bookings b
            JOIN rides r ON r.id = b.ride_id
            WHERE (b.passenger_id = ? OR r.driver_id = ?)
              AND r.travel_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY month
            ORDER BY month
        ");
        $stmt->execute([$userId, $userId]);
        $monthlyData = $stmt->fetchAll();

        $this->json([
            'success' => true,
            'summary' => [
                'total_trips_passenger' => $totalAsPassenger,
                'total_trips_driver'    => $totalAsDriver,
                'total_distance_km'     => $totalDistance,
                'total_spent'           => $totalSpent,
                'total_earned'          => $totalEarned,
                'co2_saved_kg'          => $co2Saved,
                'fuel_saved_litres'     => round($totalDistance / 15, 2), // avg 15km/L
            ],
            'monthly' => $monthlyData,
        ]);
    }

    /**
     * Admin org-wide reports (AJAX).
     * GET /reports/admin
     */
    public function adminReport(): void
    {
        $orgId = $_SESSION['org_id'] ?? 0;
        $db    = Database::getConnection();

        // Total employees
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE org_id = ? AND status = 'active'");
        $stmt->execute([$orgId]);
        $totalEmployees = (int)$stmt->fetchColumn();

        // Total rides published
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM rides r
            JOIN users u ON u.id = r.driver_id
            WHERE u.org_id = ?
        ");
        $stmt->execute([$orgId]);
        $totalRides = (int)$stmt->fetchColumn();

        // Total bookings
        $stmt = $db->prepare("
            SELECT COUNT(*) FROM bookings b
            JOIN users u ON u.id = b.passenger_id
            WHERE u.org_id = ?
        ");
        $stmt->execute([$orgId]);
        $totalBookings = (int)$stmt->fetchColumn();

        // Total distance (org-wide)
        $stmt = $db->prepare("
            SELECT COALESCE(SUM(r.distance_km), 0) FROM bookings b
            JOIN rides r ON r.id = b.ride_id
            JOIN users u ON u.id = b.passenger_id
            WHERE u.org_id = ? AND b.status IN ('trip_completed','payment_completed')
        ");
        $stmt->execute([$orgId]);
        $totalDistance = (float)$stmt->fetchColumn();

        // Participation rate
        $stmt = $db->prepare("
            SELECT COUNT(DISTINCT u.id) FROM users u
            WHERE u.org_id = ? AND u.status = 'active'
              AND (EXISTS (SELECT 1 FROM rides r WHERE r.driver_id = u.id)
                OR EXISTS (SELECT 1 FROM bookings b WHERE b.passenger_id = u.id))
        ");
        $stmt->execute([$orgId]);
        $activeParticipants = (int)$stmt->fetchColumn();

        // Vehicle-wise stats
        $stmt = $db->prepare("
            SELECT v.model, v.registration_number,
                   COUNT(DISTINCT r.id) AS rides_count,
                   COALESCE(SUM(r.distance_km), 0) AS total_km
            FROM vehicles v
            JOIN users u ON u.id = v.owner_id
            LEFT JOIN rides r ON r.vehicle_id = v.id
            WHERE u.org_id = ?
            GROUP BY v.id
            ORDER BY rides_count DESC
        ");
        $stmt->execute([$orgId]);
        $vehicleStats = $stmt->fetchAll();

        $this->json([
            'success' => true,
            'summary' => [
                'total_employees'     => $totalEmployees,
                'total_rides'         => $totalRides,
                'total_bookings'      => $totalBookings,
                'total_distance_km'   => $totalDistance,
                'active_participants' => $activeParticipants,
                'participation_rate'  => $totalEmployees > 0 ? round(($activeParticipants / $totalEmployees) * 100, 1) : 0,
                'co2_saved_kg'        => round($totalDistance * 0.06, 2),
                'cost_saved'          => round($totalDistance * 8, 2), // default ₹8/km
            ],
            'vehicle_stats' => $vehicleStats,
        ]);
    }

    /**
     * Ride History page.
     * GET /ride-history
     */
    public function history(): void
    {
        $bookingModel = new Booking();
        $history      = $bookingModel->getHistory($this->userId());

        $this->view('reports/history', [
            'history' => $history,
            'flash'   => $this->getFlash(),
        ]);
    }
}
