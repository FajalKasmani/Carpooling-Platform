<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Booking;
use App\Models\Ride;
use App\Services\NotificationService;

class TripController extends Controller
{
    /**
     * My Trips page — active/upcoming trips.
     * GET /my-trips
     */
    public function myTrips(): void
    {
        $bookingModel = new Booking();
        $rideModel    = new Ride();

        $activeTrips     = $bookingModel->getActiveTrips($this->userId());
        $offeredRides    = $rideModel->getByDriverId($this->userId());

        $this->view('trips/my-trips', [
            'activeTrips'  => $activeTrips,
            'offeredRides' => $offeredRides,
            'flash'        => $this->getFlash(),
        ]);
    }

    /**
     * Trip Details page.
     * GET /trip/:id
     */
    public function details(string $id): void
    {
        $bookingModel = new Booking();
        $booking = $bookingModel->findById((int)$id);

        if (!$booking) {
            $this->flash('error', 'Trip not found');
            $this->redirect('/my-trips');
        }

        // Verify the user is a participant
        $isDriver    = (int)$booking['driver_id'] === $this->userId();
        $isPassenger = (int)$booking['passenger_id'] === $this->userId();

        if (!$isDriver && !$isPassenger) {
            $this->flash('error', 'Access denied');
            $this->redirect('/my-trips');
        }

        // Get all passengers for this ride
        $passengers = $bookingModel->findByRide((int)$booking['ride_id']);

        $this->view('trips/details', [
            'booking'    => $booking,
            'passengers' => $passengers,
            'isDriver'   => $isDriver,
            'flash'      => $this->getFlash(),
        ]);
    }

    /**
     * Start trip (driver only).
     * POST /trip/:id/start
     */
    public function start(string $id): void
    {
        $bookingModel = new Booking();
        $booking = $bookingModel->findById((int)$id);

        if (!$booking || (int)$booking['driver_id'] !== $this->userId()) {
            $this->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        if ($booking['status'] !== 'booked') {
            $this->json(['success' => false, 'error' => 'Trip cannot be started from current status'], 400);
        }

        // Update ALL bookings for this ride
        $bookingModel->updateStatusByRide(
            (int)$booking['ride_id'],
            'booked',
            'trip_started',
            ['trip_started_at' => date('Y-m-d H:i:s')]
        );

        $this->json(['success' => true, 'message' => 'Trip started!']);
    }

    /**
     * End trip (driver only).
     * POST /trip/:id/end
     */
    public function end(string $id): void
    {
        $bookingModel = new Booking();
        $booking = $bookingModel->findById((int)$id);

        if (!$booking || (int)$booking['driver_id'] !== $this->userId()) {
            $this->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        if (!in_array($booking['status'], ['trip_started', 'trip_in_progress'])) {
            $this->json(['success' => false, 'error' => 'Trip cannot be ended from current status'], 400);
        }

        $bookingModel->updateStatusByRide(
            (int)$booking['ride_id'],
            $booking['status'],
            'trip_completed',
            ['trip_completed_at' => date('Y-m-d H:i:s')]
        );

        // Update ride status
        $rideModel = new Ride();
        $rideModel->updateStatus((int)$booking['ride_id'], 'expired');

        $this->json(['success' => true, 'message' => 'Trip completed!']);
    }

    /**
     * Push GPS location (driver only).
     * POST /trip/:id/location
     */
    public function updateLocation(string $id): void
    {
        $data = $this->jsonBody();
        $lat  = (float)($data['lat'] ?? 0);
        $lng  = (float)($data['lng'] ?? 0);

        if (!$lat || !$lng) {
            $this->json(['success' => false, 'error' => 'lat and lng required'], 400);
        }

        $bookingModel = new Booking();
        $booking = $bookingModel->findById((int)$id);

        if (!$booking || (int)$booking['driver_id'] !== $this->userId()) {
            $this->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        $rideId = (int)$booking['ride_id'];
        $db = Database::getConnection();

        // Upsert trip_locations
        $stmt = $db->prepare("
            INSERT INTO trip_locations (ride_id, current_lat, current_lng, eta_minutes)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE current_lat = ?, current_lng = ?, eta_minutes = ?
        ");
        $eta = $data['eta'] ?? null;
        $stmt->execute([$rideId, $lat, $lng, $eta, $lat, $lng, $eta]);

        $this->json(['success' => true]);
    }

    /**
     * Poll GPS location (passenger).
     * GET /trip/:id/location
     */
    public function getLocation(string $id): void
    {
        $bookingModel = new Booking();
        $booking = $bookingModel->findById((int)$id);

        if (!$booking) {
            $this->json(['success' => false, 'error' => 'Trip not found'], 404);
        }

        $rideId = (int)$booking['ride_id'];
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM trip_locations WHERE ride_id = ?");
        $stmt->execute([$rideId]);
        $loc = $stmt->fetch();

        $this->json([
            'success'  => true,
            'location' => $loc ?: null,
            'status'   => $booking['status'],
        ]);
    }

    /**
     * AJAX: Get active trips.
     * GET /api/myTrips
     */
    public function apiMyTrips(): void
    {
        $bookingModel = new Booking();
        $trips = $bookingModel->getActiveTrips($this->userId());
        $this->json(['success' => true, 'trips' => $trips]);
    }
}
