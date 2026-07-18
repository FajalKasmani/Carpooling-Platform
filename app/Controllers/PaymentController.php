<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Wallet;
use App\Services\RazorpayService;

class PaymentController extends Controller
{
    /**
     * Initiate payment for a booking.
     * POST /payments/initiate
     */
    public function initiate(): void
    {
        $data      = $this->jsonBody();
        $bookingId = (int)($data['booking_id'] ?? 0);
        $method    = $data['method'] ?? 'wallet';

        $bookingModel = new Booking();
        $booking      = $bookingModel->findById($bookingId);

        if (!$booking) {
            $this->json(['success' => false, 'error' => 'Booking not found'], 404);
        }

        $amount = (float)$booking['fare_amount'];

        // Create payment record
        $paymentModel = new Payment();

        if ($method === 'wallet') {
            $walletModel = new Wallet();
            $balance     = $walletModel->getBalance($this->userId());

            if ($balance < $amount) {
                $this->json(['success' => false, 'error' => "Insufficient balance (₹{$balance})"], 400);
            }

            $paymentId = $paymentModel->create([
                'booking_id' => $bookingId,
                'amount'     => $amount,
                'method'     => 'wallet',
                'status'     => 'success',
            ]);

            $walletModel->debit($this->userId(), $amount, "payment_{$paymentId}");
            $bookingModel->updateStatus($bookingId, 'payment_completed');

            $this->json([
                'success'     => true,
                'payment_id'  => $paymentId,
                'message'     => 'Payment successful!',
                'new_balance' => $walletModel->getBalance($this->userId()),
            ]);
        } elseif ($method === 'cash') {
            $paymentId = $paymentModel->create([
                'booking_id' => $bookingId,
                'amount'     => $amount,
                'method'     => 'cash',
                'status'     => 'pending',
            ]);

            $this->json([
                'success'    => true,
                'payment_id' => $paymentId,
                'message'    => 'Cash payment registered. Driver will confirm receipt.',
            ]);
        } else {
            // Razorpay (card/upi)
            $razorpay = new RazorpayService();
            $order    = $razorpay->createOrder($amount, "booking_{$bookingId}");

            if (!$order) {
                $this->json(['success' => false, 'error' => 'Failed to create payment order'], 500);
            }

            $paymentId = $paymentModel->create([
                'booking_id' => $bookingId,
                'amount'     => $amount,
                'method'     => $method,
                'status'     => 'pending',
            ]);

            $this->json([
                'success'          => true,
                'payment_id'       => $paymentId,
                'razorpay_order'   => $order,
                'razorpay_key_id'  => $razorpay->getKeyId(),
            ]);
        }
    }

    /**
     * Verify Razorpay payment.
     * POST /payments/verify
     */
    public function verify(): void
    {
        $data = $this->jsonBody();

        $razorpay = new RazorpayService();
        $valid    = $razorpay->verifySignature(
            $data['razorpay_order_id']   ?? '',
            $data['razorpay_payment_id'] ?? '',
            $data['razorpay_signature']  ?? ''
        );

        if (!$valid) {
            $this->json(['success' => false, 'error' => 'Payment verification failed'], 400);
        }

        $paymentModel = new Payment();
        $paymentId    = (int)($data['payment_id'] ?? 0);

        $paymentModel->updateStatus($paymentId, 'success', $data['razorpay_payment_id']);

        // Find the booking associated with this payment and update status
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT booking_id FROM payments WHERE id = ?");
        $stmt->execute([$paymentId]);
        $payment = $stmt->fetch();

        if ($payment) {
            $bookingModel = new Booking();
            $bookingModel->updateStatus((int)$payment['booking_id'], 'payment_completed');
        }

        $this->json(['success' => true, 'message' => 'Payment verified successfully!']);
    }

    /**
     * Confirm cash payment received (driver action).
     * POST /payments/cash-confirm
     */
    public function cashConfirm(): void
    {
        $data      = $this->jsonBody();
        $bookingId = (int)($data['booking_id'] ?? 0);

        $bookingModel = new Booking();
        $booking      = $bookingModel->findById($bookingId);

        if (!$booking || (int)$booking['driver_id'] !== $this->userId()) {
            $this->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        // Update payment status
        $paymentModel = new Payment();
        $payment      = $paymentModel->findByBooking($bookingId);

        if ($payment && $payment['method'] === 'cash') {
            $paymentModel->updateStatus((int)$payment['id'], 'success');
        }

        $bookingModel->updateStatus($bookingId, 'payment_completed');

        $this->json(['success' => true, 'message' => 'Cash payment confirmed']);
    }
}
