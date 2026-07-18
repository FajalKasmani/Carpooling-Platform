<?php
namespace App\Core;

/**
 * BaseModel — provides PDO connection to all models.
 */
class Model
{
    protected \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }
}
