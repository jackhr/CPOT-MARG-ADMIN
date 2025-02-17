<?php

namespace App\Models;

use App\Helpers\GeneralHelper;
use PDO;

class OneOfAKind extends Model
{
    public $one_of_a_kind_id;
    public $primary_image_id;
    public $name;
    public $slug;
    public $dimensions;
    public $material;
    public $artist;
    public $price;
    public $status;
    public $description;
    public $availability;
    public $care_instructions;
    public $release_date;
    public $created_at;
    public $updated_at;
    public $deleted_at;
    public $created_by;
    public $updated_by;

    public $helper;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "one_of_a_kind";
        $this->primary_key = "one_of_a_kind_id";
        $this->helper = new GeneralHelper();
    }

    public function updatePrimaryImg()
    {
        $query = "UPDATE {$this->table_name} SET primary_image_id = :primary_image_id WHERE one_of_a_kind_id = :one_of_a_kind_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->one_of_a_kind_id = htmlspecialchars($this->one_of_a_kind_id);
        $this->primary_image_id = htmlspecialchars($this->primary_image_id);

        // Bind parameters
        $stmt->bindParam(":primary_image_id", $this->primary_image_id, PDO::PARAM_INT);
        $stmt->bindParam(":one_of_a_kind_id", $this->one_of_a_kind_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function restore()
    {
        $query = "UPDATE {$this->table_name} SET deleted_at = NULL, `status` = 'active' WHERE one_of_a_kind_id = :one_of_a_kind_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->one_of_a_kind_id = htmlspecialchars($this->one_of_a_kind_id);

        // Bind parameters
        $stmt->bindParam(":one_of_a_kind_id", $this->one_of_a_kind_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function update()
    {
        $query = "UPDATE {$this->table_name} SET name = :name, dimensions = :dimensions, material = :material, artist = :artist, price = :price, status = :status, description = :description, updated_by = :updated_by WHERE one_of_a_kind_id = :one_of_a_kind_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->one_of_a_kind_id = htmlspecialchars($this->one_of_a_kind_id);
        $this->name = htmlspecialchars($this->name);
        $this->dimensions = htmlspecialchars($this->dimensions);
        $this->material = htmlspecialchars($this->material);
        $this->artist = htmlspecialchars($this->artist);
        $this->price = htmlspecialchars($this->price);
        $this->status = htmlspecialchars($this->status);
        $this->description = htmlspecialchars($this->description);
        $this->updated_by = htmlspecialchars($this->updated_by);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":dimensions", $this->dimensions);
        $stmt->bindParam(":material", $this->material);
        $stmt->bindParam(":artist", $this->artist);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":one_of_a_kind_id", $this->one_of_a_kind_id, PDO::PARAM_INT);
        $stmt->bindParam(":updated_by", $this->updated_by, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function create()
    {
        $query = "INSERT INTO {$this->table_name} SET name = :name, dimensions = :dimensions, material = :material, artist = :artist, price = :price, status = :status, description = :description, created_by = :created_by";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->name = htmlspecialchars($this->name);
        $this->dimensions = htmlspecialchars($this->dimensions);
        $this->material = htmlspecialchars($this->material);
        $this->artist = htmlspecialchars($this->artist);
        $this->price = htmlspecialchars($this->price);
        $this->status = htmlspecialchars($this->status);
        $this->description = htmlspecialchars($this->description);
        $this->created_by = htmlspecialchars($this->created_by);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":dimensions", $this->dimensions);
        $stmt->bindParam(":material", $this->material);
        $stmt->bindParam(":artist", $this->artist);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created_by", $this->created_by, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function delete()
    {
        $query = "UPDATE {$this->table_name} SET deleted_at = CURRENT_TIMESTAMP, `status` = 'archived' WHERE one_of_a_kind_id = :one_of_a_kind_id";

        $stmt = $this->con->prepare($query);

        $this->one_of_a_kind_id = htmlspecialchars($this->one_of_a_kind_id);

        $stmt->bindParam(":one_of_a_kind_id", $this->one_of_a_kind_id, PDO::PARAM_INT);

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
