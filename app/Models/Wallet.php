<?php
namespace App\Models;

use App\Core\Model;

class Wallet extends Model
{
    /**
     * Get wallet balance for a user.
     */
    public function getBalance(int $userId): float
    {
        $stmt = $this->db->prepare("SELECT balance FROM wallets WHERE user_id = ?");
        $stmt->execute([$userId]);
        $row = $stmt->fetch();

        if (!$row) {
            // Auto-create wallet if missing
            $this->db->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, 0.00)")->execute([$userId]);
            return 0.00;
        }

        return (float)$row['balance'];
    }

    /**
     * Get wallet ID for a user.
     */
    public function getWalletId(int $userId): int
    {
        $stmt = $this->db->prepare("SELECT id FROM wallets WHERE user_id = ?");
        $stmt->execute([$userId]);
        $row = $stmt->fetch();

        if (!$row) {
            $this->db->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, 0.00)")->execute([$userId]);
            return (int)$this->db->lastInsertId();
        }

        return (int)$row['id'];
    }

    /**
     * Recharge wallet (add funds).
     */
    public function recharge(int $userId, float $amount, ?string $reference = null): float
    {
        $walletId = $this->getWalletId($userId);

        $this->db->prepare("UPDATE wallets SET balance = balance + ? WHERE user_id = ?")
                 ->execute([$amount, $userId]);

        // Log transaction
        $this->db->prepare("
            INSERT INTO wallet_transactions (wallet_id, type, amount, reference)
            VALUES (?, 'recharge', ?, ?)
        ")->execute([$walletId, $amount, $reference]);

        return $this->getBalance($userId);
    }

    /**
     * Debit wallet (deduct funds).
     */
    public function debit(int $userId, float $amount, ?string $reference = null, bool $force = false): bool
    {
        $balance = $this->getBalance($userId);
        if (!$force && $balance < $amount) {
            return false;
        }

        $walletId = $this->getWalletId($userId);

        $this->db->prepare("UPDATE wallets SET balance = balance - ? WHERE user_id = ?")
                 ->execute([$amount, $userId]);

        $this->db->prepare("
            INSERT INTO wallet_transactions (wallet_id, type, amount, reference)
            VALUES (?, 'debit', ?, ?)
        ")->execute([$walletId, $amount, $reference]);

        return true;
    }

    /**
     * Credit wallet (add funds from ride payment).
     */
    public function credit(int $userId, float $amount, ?string $reference = null): void
    {
        $walletId = $this->getWalletId($userId);

        $this->db->prepare("UPDATE wallets SET balance = balance + ? WHERE user_id = ?")
                 ->execute([$amount, $userId]);

        $this->db->prepare("
            INSERT INTO wallet_transactions (wallet_id, type, amount, reference)
            VALUES (?, 'recharge', ?, ?)
        ")->execute([$walletId, $amount, $reference]);
    }

    /**
     * Get transaction history for a user.
     */
    public function getTransactions(int $userId, int $limit = 20): array
    {
        $walletId = $this->getWalletId($userId);

        $stmt = $this->db->prepare("
            SELECT * FROM wallet_transactions
            WHERE wallet_id = ?
            ORDER BY created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$walletId, $limit]);
        return $stmt->fetchAll();
    }
}
