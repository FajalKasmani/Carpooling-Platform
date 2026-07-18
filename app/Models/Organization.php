<?php
namespace App\Models;

use App\Core\Model;

class Organization extends Model
{
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM organizations WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function findByDomain(string $domain): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM organizations WHERE domain = ?");
        $stmt->execute([$domain]);
        return $stmt->fetch() ?: null;
    }

    public function updateSettings(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE organizations
            SET fuel_cost_per_km = ?, default_fare_per_km = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['fuel_cost_per_km'],
            $data['default_fare_per_km'],
            $id,
        ]);
    }

    public function getAll(): array
    {
        return $this->db->query("SELECT * FROM organizations ORDER BY name")->fetchAll();
    }
}
