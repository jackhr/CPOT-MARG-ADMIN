<?php

namespace App\Models;

use App\Helpers\GeneralHelper;
use PDO;

class Sconce extends Model
{
    public $sconce_id;
    public $primary_image_id;
    public $name;
    public $slug;
    public $dimensions;
    public $material;
    public $color;
    public $weight;
    public $base_price;
    public $stock_quantity;
    public $status;
    public $installation_type;
    public $style;
    public $description;
    public $availability;
    public $care_instructions;
    public $release_date;
    public $custom_options;
    public $created_at;
    public $updated_at;
    public $deleted_at;
    public $created_by;
    public $updated_by;

    public $helper;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "sconces";
        $this->primary_key = "sconce_id";
        $this->helper = new GeneralHelper();
    }

    public function updatePrimaryImg()
    {
        $query = "UPDATE {$this->table_name} SET primary_image_id = :primary_image_id WHERE sconce_id = :sconce_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->sconce_id = htmlspecialchars($this->sconce_id);
        $this->primary_image_id = htmlspecialchars($this->primary_image_id);

        // Bind parameters
        $stmt->bindParam(":primary_image_id", $this->primary_image_id, PDO::PARAM_INT);
        $stmt->bindParam(":sconce_id", $this->sconce_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function restore()
    {
        $query = "UPDATE {$this->table_name} SET deleted_at = NULL, `status` = 'active' WHERE sconce_id = :sconce_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->sconce_id = htmlspecialchars($this->sconce_id);

        // Bind parameters
        $stmt->bindParam(":sconce_id", $this->sconce_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function update()
    {
        $query = "UPDATE {$this->table_name} SET name = :name, dimensions = :dimensions, material = :material, color = :color, weight = :weight, base_price = :base_price, stock_quantity = :stock_quantity, status = :status, description = :description, updated_by = :updated_by WHERE sconce_id = :sconce_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->sconce_id = htmlspecialchars($this->sconce_id);
        $this->name = htmlspecialchars($this->name);
        $this->dimensions = htmlspecialchars($this->dimensions);
        $this->material = htmlspecialchars($this->material);
        $this->color = htmlspecialchars($this->color);
        $this->weight = htmlspecialchars($this->weight);
        $this->base_price = htmlspecialchars($this->base_price);
        $this->stock_quantity = htmlspecialchars($this->stock_quantity);
        $this->status = htmlspecialchars($this->status);
        $this->description = htmlspecialchars($this->description);
        $this->updated_by = htmlspecialchars($this->updated_by);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":dimensions", $this->dimensions);
        $stmt->bindParam(":material", $this->material);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":weight", $this->weight);
        $stmt->bindParam(":base_price", $this->base_price);
        $stmt->bindParam(":stock_quantity", $this->stock_quantity);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":sconce_id", $this->sconce_id, PDO::PARAM_INT);
        $stmt->bindParam(":updated_by", $this->updated_by, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function create()
    {
        $query = "INSERT INTO {$this->table_name} SET name = :name, dimensions = :dimensions, material = :material, color = :color, weight = :weight, base_price = :base_price, stock_quantity = :stock_quantity, status = :status, description = :description, created_by = :created_by";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->name = htmlspecialchars($this->name);
        $this->dimensions = htmlspecialchars($this->dimensions);
        $this->material = htmlspecialchars($this->material);
        $this->color = htmlspecialchars($this->color);
        $this->weight = htmlspecialchars($this->weight);
        $this->base_price = htmlspecialchars($this->base_price);
        $this->stock_quantity = htmlspecialchars($this->stock_quantity);
        $this->status = htmlspecialchars($this->status);
        $this->description = htmlspecialchars($this->description);
        $this->created_by = htmlspecialchars($this->created_by);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":dimensions", $this->dimensions);
        $stmt->bindParam(":material", $this->material);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":weight", $this->weight);
        $stmt->bindParam(":base_price", $this->base_price);
        $stmt->bindParam(":stock_quantity", $this->stock_quantity);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created_by", $this->created_by, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function delete()
    {
        $query = "UPDATE {$this->table_name} SET deleted_at = CURRENT_TIMESTAMP, `status` = 'archived' WHERE sconce_id = :sconce_id";
        $stmt = $this->con->prepare($query);

        $this->sconce_id = htmlspecialchars($this->sconce_id);

        $stmt->bindParam(":sconce_id", $this->sconce_id, PDO::PARAM_INT);

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
