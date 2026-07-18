<?php
namespace App\Models;

use App\Core\Model;

class Vehicle extends Model
{
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM vehicles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getByOwnerId(int $ownerId): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM vehicles
            WHERE owner_id = ? AND status = 'active'
            ORDER BY created_at DESC
        ");
        $stmt->execute([$ownerId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO vehicles (owner_id, model, registration_number, seating_capacity)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['owner_id'],
            $data['model'],
            $data['registration_number'],
            $data['seating_capacity'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE vehicles
            SET model = ?, registration_number = ?, seating_capacity = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['model'],
            $data['registration_number'],
            $data['seating_capacity'],
            $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE vehicles SET status = 'inactive' WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function regNumberExists(string $regNumber, ?int $excludeId = null): bool
    {
        $sql = "SELECT 1 FROM vehicles WHERE registration_number = ?";
        $params = [$regNumber];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (bool)$stmt->fetch();
    }

    /**
     * Get all vehicles for an org (admin view).
     */
    public function getByOrgId(int $orgId): array
    {
        $stmt = $this->db->prepare("
            SELECT v.*, u.name AS owner_name, u.email AS owner_email
            FROM vehicles v
            JOIN users u ON u.id = v.owner_id
            WHERE u.org_id = ?
            ORDER BY v.created_at DESC
        ");
        $stmt->execute([$orgId]);
        return $stmt->fetchAll();
    }
}
