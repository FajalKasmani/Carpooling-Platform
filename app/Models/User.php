<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    /**
     * Find user by email.
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("
            SELECT u.*, o.name AS org_name, o.domain AS org_domain,
                   COALESCE(w.balance, 0) AS wallet_balance
            FROM users u
            LEFT JOIN organizations o ON o.id = u.org_id
            LEFT JOIN wallets w ON w.user_id = u.id
            WHERE u.email = ?
        ");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Find user by ID.
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT u.id, u.org_id, u.name, u.email, u.phone, u.role,
                   u.profile_photo, u.status, u.created_at,
                   o.name AS org_name,
                   COALESCE(w.balance, 0) AS wallet_balance
            FROM users u
            LEFT JOIN organizations o ON o.id = u.org_id
            LEFT JOIN wallets w ON w.user_id = u.id
            WHERE u.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Create a new user.
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (org_id, name, email, phone, password_hash, role)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['org_id'],
            $data['name'],
            $data['email'],
            $data['phone'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role'] ?? 'employee',
        ]);

        $userId = (int)$this->db->lastInsertId();

        // Auto-create wallet for the new user
        $this->db->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, 0.00)")
                 ->execute([$userId]);

        return $userId;
    }

    /**
     * Update user status (admin action).
     */
    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    /**
     * Update user profile.
     */
    public function updateProfile(int $id, array $data): bool
    {
        $fields = [];
        $values = [];

        foreach (['name', 'phone', 'profile_photo'] as $field) {
            if (isset($data[$field])) {
                $fields[] = "{$field} = ?";
                $values[] = $data[$field];
            }
        }

        if (empty($fields)) return false;

        $values[] = $id;
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        return $this->db->prepare($sql)->execute($values);
    }

    /**
     * Get all users for an organization (admin).
     */
    public function getByOrgId(int $orgId): array
    {
        $stmt = $this->db->prepare("
            SELECT u.id, u.name, u.email, u.phone, u.role, u.status, u.created_at,
                   COALESCE(w.balance, 0) AS wallet_balance
            FROM users u
            LEFT JOIN wallets w ON w.user_id = u.id
            WHERE u.org_id = ?
            ORDER BY u.created_at DESC
        ");
        $stmt->execute([$orgId]);
        return $stmt->fetchAll();
    }

    /**
     * Count users by org.
     */
    public function countByOrg(int $orgId): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE org_id = ? AND status = 'active'");
        $stmt->execute([$orgId]);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Check if email exists.
     */
    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT 1 FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return (bool)$stmt->fetch();
    }
}
