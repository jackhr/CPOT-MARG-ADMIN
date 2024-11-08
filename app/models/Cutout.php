<?php

namespace App\Models;

use PDO;

class Cutout extends Model
{
    public $cutout_id;
    public $name;
    public $description;
    public $image_url;
    public $cutout_type;
    public $created_at;
    public $updated_at;
    public $deleted_at;
    public $created_by;
    public $updated_by;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "cutouts";
    }

    public function create()
    {
        $query = "INSERT INTO {$this->table_name} SET name = :name, description = :description, image_url = :image_url, cutout_type = :cutout_type, created_by = :created_by";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->name = htmlspecialchars($this->name);
        $this->description = htmlspecialchars($this->description);
        $this->image_url = htmlspecialchars($this->image_url);
        $this->cutout_type = htmlspecialchars($this->cutout_type);
        $this->created_by = htmlspecialchars($this->created_by);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image_url", $this->image_url);
        $stmt->bindParam(":cutout_type", $this->cutout_type);
        $stmt->bindParam(":created_by", $this->created_by, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function update()
    {
        $query = "UPDATE {$this->table_name} SET name = :name, description = :description, image_url = :image_url, cutout_type = :cutout_type, updated_by = :updated_by WHERE cutout_id = :cutout_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->cutout_id = htmlspecialchars($this->cutout_id);
        $this->name = htmlspecialchars($this->name);
        $this->description = htmlspecialchars($this->description);
        $this->image_url = htmlspecialchars($this->image_url);
        $this->cutout_type = htmlspecialchars($this->cutout_type);
        $this->updated_by = htmlspecialchars($this->updated_by);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image_url", $this->image_url);
        $stmt->bindParam(":cutout_type", $this->cutout_type);
        $stmt->bindParam(":updated_by", $this->updated_by, PDO::PARAM_INT);
        $stmt->bindParam(":cutout_id", $this->cutout_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function delete()
    {
        $query = "UPDATE {$this->table_name} SET deleted_at = CURRENT_TIMESTAMP WHERE cutout_id = :cutout_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->cutout_id = htmlspecialchars($this->cutout_id);

        // Bind parameters
        $stmt->bindParam(":cutout_id", $this->cutout_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    // Method to find a user by username
    public function findByName($name)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE name = :name";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($cutout_id)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE cutout_id = :cutout_id";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":cutout_id", $cutout_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
