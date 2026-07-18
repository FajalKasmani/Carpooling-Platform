<?php
namespace App\Models;

use App\Core\Model;

class Payment extends Model
{
    /**
     * Create a new payment record.
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO payments (booking_id, amount, method, razorpay_payment_id, status)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['booking_id'],
            $data['amount'],
            $data['method'],
            $data['razorpay_payment_id'] ?? null,
            $data['status'] ?? 'pending',
        ]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Update payment status.
     */
    public function updateStatus(int $id, string $status, ?string $razorpayId = null): bool
    {
        $sql = "UPDATE payments SET status = ?, paid_at = NOW()";
        $params = [$status];

        if ($razorpayId) {
            $sql .= ", razorpay_payment_id = ?";
            $params[] = $razorpayId;
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;

        return $this->db->prepare($sql)->execute($params);
    }

    /**
     * Find payment by booking ID.
     */
    public function findByBooking(int $bookingId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM payments WHERE booking_id = ? ORDER BY id DESC LIMIT 1");
        $stmt->execute([$bookingId]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Get total revenue for an org (admin reports).
     */
    public function totalRevenueByOrg(int $orgId): float
    {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(p.amount), 0)
            FROM payments p
            JOIN bookings b ON b.id = p.booking_id
            JOIN users u ON u.id = b.passenger_id
            WHERE u.org_id = ? AND p.status = 'success'
        ");
        $stmt->execute([$orgId]);
        return (float)$stmt->fetchColumn();
    }
}
