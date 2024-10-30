<?php

namespace App\Models;

use App\Config\Database;
use Exception;
use PDO;

class Role
{
    private $con;
    private $table_name = "roles";

    public $role_id;
    public $role_name;

    public function __construct()
    {
        $database = new Database();
        $this->con = $database->getConnection();
    }

    public function update()
    {
        $query = "UPDATE {$this->table_name} SET role_name = :role_name WHERE role_id = :role_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->role_name = htmlspecialchars($this->role_name);
        $this->role_id = htmlspecialchars($this->role_id);

        // Bind parameters
        $stmt->bindParam(":role_name", $this->role_name);
        $stmt->bindParam(":role_id", $this->role_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }


    // Method to create a new role
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " SET role_name=:role_name";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->role_name = htmlspecialchars(strip_tags($this->role_name));

        // Bind parameters
        $stmt->bindParam(":role_name", $this->role_name);

        // Execute the query
        return $stmt->execute();
    }

    // Method to fetch all roles
    public function readAll()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to find a role by ID
    public function findById($role_id)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE role_id = :role_id";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":role_id", $role_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to find a user by username
    public function findByRoleName($role_name)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE role_name = :role_name";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":role_name", $role_name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function Users($role_id = null)
    {
        $role_id_to_use = $role_id ?? $this->role_id;

        // Check if role_id is valid
        if (!isset($role_id_to_use)) {
            throw new Exception("Role ID is not set. Please provide a valid role ID.");
        }

        $query = "SELECT * FROM users WHERE role_id = :role_id";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":role_id", $role_id_to_use, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete()
    {
        $query = "DELETE FROM {$this->table_name} WHERE role_id = :role_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->role_id = htmlspecialchars($this->role_id);

        // Bind parameters
        $stmt->bindParam(":role_id", $this->role_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }
}
