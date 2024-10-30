<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Role
{
    private $con;
    private $table_name = "roles";

    public $role_name;

    public function __construct()
    {
        $database = new Database();
        $this->con = $database->getConnection();
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
}
