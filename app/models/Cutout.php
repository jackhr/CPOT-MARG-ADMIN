<?php

namespace App\Models;

use App\Helpers\GeneralHelper;
use PDO;

class Cutout extends Model
{
    public $cutout_id;
    public $primary_image_id;
    public $name;
    public $code;
    public $description;
    public $base_price;
    public $created_at;
    public $updated_at;
    public $deleted_at;
    public $created_by;
    public $updated_by;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "cutouts";
        $this->primary_key = "cutout_id";
    }

    public function create()
    {
        $query = "INSERT INTO {$this->table_name} SET name = :name, code = :code, description = :description, base_price = :base_price, created_by = :created_by";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->name = htmlspecialchars($this->name);
        $this->code = htmlspecialchars($this->code);
        $this->description = htmlspecialchars($this->description);
        $this->base_price = htmlspecialchars($this->base_price);
        $this->created_by = htmlspecialchars($this->created_by);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":code", $this->code);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":base_price", $this->base_price);
        $stmt->bindParam(":created_by", $this->created_by, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function update()
    {
        $query = "UPDATE {$this->table_name} SET name = :name, code = :code, description = :description, base_price = :base_price, updated_by = :updated_by WHERE cutout_id = :cutout_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->cutout_id = htmlspecialchars($this->cutout_id);
        $this->name = htmlspecialchars($this->name);
        $this->code = htmlspecialchars($this->code);
        $this->description = htmlspecialchars($this->description);
        $this->base_price = htmlspecialchars($this->base_price);
        $this->updated_by = htmlspecialchars($this->updated_by);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":code", $this->code);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":base_price", $this->base_price);
        $stmt->bindParam(":updated_by", $this->updated_by, PDO::PARAM_INT);
        $stmt->bindParam(":cutout_id", $this->cutout_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function updatePrimaryImg()
    {
        $query = "UPDATE {$this->table_name} SET primary_image_id = :primary_image_id WHERE cutout_id = :cutout_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->cutout_id = htmlspecialchars($this->cutout_id);
        $this->primary_image_id = htmlspecialchars($this->primary_image_id);

        // Bind parameters
        $stmt->bindParam(":primary_image_id", $this->primary_image_id, PDO::PARAM_INT);
        $stmt->bindParam(":cutout_id", $this->cutout_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function restore()
    {
        $query = "UPDATE {$this->table_name} SET deleted_at = NULL WHERE cutout_id = :cutout_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->cutout_id = htmlspecialchars($this->cutout_id);

        // Bind parameters
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
}
