<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Ride;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Wallet;
use App\Models\User;
use App\Helpers\Validator;
use App\Services\NotificationService;

class RideController extends Controller
{
    /**
     * Show Find Ride page.
     * GET /find-ride
     */
    public function showFind(): void
    {
        $this->view('rides/find', [
            'flash' => $this->getFlash(),
        ]);
    }

    /**
     * Search for matching rides (AJAX).
     * POST /rides/search
     */
    public function search(): void
    {
        $data = $this->jsonBody();

        $v = new Validator($data);
        $v->required('travel_date');

        if ($v->fails()) {
            $this->json(['success' => false, 'error' => $v->firstError()], 400);
        }

        $rideModel = new Ride();
        $rides = $rideModel->search([
            'pickup_lat'  => $data['pickup_lat']  ?? null,
            'pickup_lng'  => $data['pickup_lng']  ?? null,
            'drop_lat'    => $data['drop_lat']    ?? null,
            'drop_lng'    => $data['drop_lng']    ?? null,
            'travel_date' => $data['travel_date'],
            'travel_time' => $data['travel_time'] ?? '09:00',
            'seats'       => $data['seats']       ?? 1,
            'org_id'      => $_SESSION['org_id'],
        ]);

        $this->json(['success' => true, 'rides' => $rides, 'count' => count($rides)]);
    }

    /**
     * Show Available Rides page (after search).
     * GET /rides/available
     */
    public function available(): void
    {
        $this->view('rides/available');
    }

    /**
     * Show Offer Ride page.
     * GET /offer-ride
     */
    public function showOffer(): void
    {
        $vehicleModel = new Vehicle();
        $vehicles = $vehicleModel->getByOwnerId($this->userId());

        $this->view('rides/offer', [
            'vehicles' => $vehicles,
            'flash'    => $this->getFlash(),
        ]);
    }

    /**
     * Create a new ride (Offer Ride).
     * POST /offerRide
     */
    public function offer(): void
    {
        $data = $this->jsonBody();
        if (empty($data)) $data = $_POST;

        $v = new Validator($data);
        $v->required('pickup_address')
          ->required('drop_address')
          ->required('travel_date')
          ->required('travel_time')
          ->required('vehicle_id')
          ->required('available_seats')->min('available_seats', 1)
          ->required('fare_per_seat')->min('fare_per_seat', 1);

        if ($v->fails()) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'error' => $v->firstError()], 400);
            }
            $this->flash('error', $v->firstError());
            $this->redirect('/offer-ride');
        }

        // Verify vehicle belongs to user
        $vehicleModel = new Vehicle();
        $vehicle = $vehicleModel->findById((int)$data['vehicle_id']);

        if (!$vehicle || (int)$vehicle['owner_id'] !== $this->userId()) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'error' => 'Invalid vehicle'], 403);
            }
            $this->flash('error', 'Invalid vehicle selection');
            $this->redirect('/offer-ride');
        }

        $rideModel = new Ride();
        $rideId = $rideModel->create([
            'driver_id'       => $this->userId(),
            'vehicle_id'      => (int)$data['vehicle_id'],
            'pickup_address'  => $data['pickup_address'],
            'pickup_lat'      => $data['pickup_lat']  ?? null,
            'pickup_lng'      => $data['pickup_lng']  ?? null,
            'drop_address'    => $data['drop_address'],
            'drop_lat'        => $data['drop_lat']    ?? null,
            'drop_lng'        => $data['drop_lng']    ?? null,
            'route_polyline'  => $data['route_polyline'] ?? null,
            'travel_date'     => $data['travel_date'],
            'travel_time'     => $data['travel_time'],
            'available_seats' => (int)$data['available_seats'],
            'fare_per_seat'   => (float)$data['fare_per_seat'],
            'distance_km'     => $data['distance_km'] ?? null,
            'is_recurring'    => $data['is_recurring'] ?? false,
        ]);

        if ($this->isAjax()) {
            $this->json(['success' => true, 'ride_id' => $rideId, 'message' => 'Ride published successfully!']);
        }

        NotificationService::push('success', 'Ride published successfully!');
        $this->redirect('/my-trips');
    }

    /**
     * Book a ride (instant booking).
     * POST /bookRide
     */
    public function book(): void
    {
        $data = $this->jsonBody();

        $rideId = (int)($data['ride_id'] ?? 0);
        $seats  = (int)($data['seats']   ?? 1);

        if (!$rideId) {
            $this->json(['success' => false, 'error' => 'ride_id is required'], 400);
        }

        $rideModel    = new Ride();
        $bookingModel = new Booking();
        $walletModel  = new Wallet();
        $db = \App\Core\Database::getConnection();

        $db->beginTransaction();

        try {
            // Lock the ride row
            $ride = $rideModel->findForBooking($rideId);

            if (!$ride) {
                $db->rollBack();
                $this->json(['success' => false, 'error' => 'Ride not found or no longer available'], 404);
            }

            // Cannot book your own ride
            if ((int)$ride['driver_id'] === $this->userId()) {
                $db->rollBack();
                $this->json(['success' => false, 'error' => 'You cannot book your own ride'], 400);
            }

            // Check duplicate
            if ($bookingModel->alreadyBooked($rideId, $this->userId())) {
                $db->rollBack();
                $this->json(['success' => false, 'error' => 'You have already booked this ride'], 400);
            }

            // Check seat availability
            if ((int)$ride['available_seats'] < $seats) {
                $db->rollBack();
                $this->json(['success' => false, 'error' => 'Not enough seats available'], 400);
            }

            $fareAmount = (float)$ride['fare_per_seat'] * $seats;

            // Check wallet balance
            $balance = $walletModel->getBalance($this->userId());
            if ($balance < $fareAmount) {
                $db->rollBack();
                $this->json(['success' => false, 'error' => "Insufficient wallet balance. Need ₹{$fareAmount}, have ₹{$balance}"], 400);
            }

            // Create booking
            $bookingId = $bookingModel->create([
                'ride_id'      => $rideId,
                'passenger_id' => $this->userId(),
                'seats_booked' => $seats,
                'fare_amount'  => $fareAmount,
            ]);

            // Decrement seats
            $rideModel->decrementSeats($rideId, $seats);

            // Mark ride as full if no seats left
            if ((int)$ride['available_seats'] - $seats <= 0) {
                $rideModel->updateStatus($rideId, 'full');
            }

            $db->commit();

            $newBalance = $walletModel->getBalance($this->userId());

            $this->json([
                'success'     => true,
                'booking_id'  => $bookingId,
                'fare_amount' => $fareAmount,
                'new_balance' => $newBalance,
                'message'     => 'Ride booked successfully! 🎉',
            ]);
        } catch (\Exception $e) {
            $db->rollBack();
            $this->json(['success' => false, 'error' => 'Booking failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show route confirmation page.
     * GET /rides/confirm
     */
    public function confirmRoute(): void
    {
        $this->view('rides/confirm');
    }

    /**
     * Helper: check if request is AJAX.
     */
    private function isAjax(): bool
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
    }
}
