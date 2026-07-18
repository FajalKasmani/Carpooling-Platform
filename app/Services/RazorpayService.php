<?php
namespace App\Services;

/**
 * RazorpayService — wraps Razorpay order creation and payment verification.
 * Uses Test Mode keys from .env.
 */
class RazorpayService
{
    private string $keyId;
    private string $keySecret;

    public function __construct()
    {
        $this->keyId     = $_ENV['RAZORPAY_KEY_ID']     ?? '';
        $this->keySecret = $_ENV['RAZORPAY_KEY_SECRET'] ?? '';
    }

    /**
     * Create a Razorpay order.
     *
     * @param float  $amount  Amount in INR
     * @param string $receipt Unique receipt identifier
     */
    public function createOrder(float $amount, string $receipt): ?array
    {
        if (!$this->keyId || !$this->keySecret) {
            return null; // Razorpay not configured
        }

        $url  = 'https://api.razorpay.com/v1/orders';
        $data = json_encode([
            'amount'   => (int)($amount * 100), // paise
            'currency' => 'INR',
            'receipt'  => $receipt,
        ]);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_USERPWD        => "{$this->keyId}:{$this->keySecret}",
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT        => 10,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            return json_decode($response, true);
        }

        return null;
    }

    /**
     * Verify Razorpay payment signature.
     */
    public function verifySignature(string $orderId, string $paymentId, string $signature): bool
    {
        $expected = hash_hmac('sha256', "{$orderId}|{$paymentId}", $this->keySecret);
        return hash_equals($expected, $signature);
    }

    /**
     * Get the Razorpay key ID (for client-side checkout widget).
     */
    public function getKeyId(): string
    {
        return $this->keyId;
    }
}
