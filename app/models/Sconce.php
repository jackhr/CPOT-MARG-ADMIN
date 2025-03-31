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
        $query = "UPDATE {$this->table_name} SET name = :name, dimensions = :dimensions, material = :material, color = :color, base_price = :base_price, status = :status, description = :description, updated_by = :updated_by WHERE sconce_id = :sconce_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->sconce_id = htmlspecialchars($this->sconce_id);
        $this->name = htmlspecialchars($this->name);
        $this->dimensions = htmlspecialchars($this->dimensions);
        $this->material = htmlspecialchars($this->material);
        $this->color = htmlspecialchars($this->color);
        $this->base_price = htmlspecialchars($this->base_price);
        $this->status = htmlspecialchars($this->status);
        $this->description = htmlspecialchars($this->description);
        $this->updated_by = htmlspecialchars($this->updated_by);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":dimensions", $this->dimensions);
        $stmt->bindParam(":material", $this->material);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":base_price", $this->base_price);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":sconce_id", $this->sconce_id, PDO::PARAM_INT);
        $stmt->bindParam(":updated_by", $this->updated_by, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function create()
    {
        $query = "INSERT INTO {$this->table_name} SET name = :name, dimensions = :dimensions, material = :material, color = :color, base_price = :base_price, status = :status, description = :description, created_by = :created_by";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->name = htmlspecialchars($this->name);
        $this->dimensions = htmlspecialchars($this->dimensions);
        $this->material = htmlspecialchars($this->material);
        $this->color = htmlspecialchars($this->color);
        $this->base_price = htmlspecialchars($this->base_price);
        $this->status = htmlspecialchars($this->status);
        $this->description = htmlspecialchars($this->description);
        $this->created_by = htmlspecialchars($this->created_by);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":dimensions", $this->dimensions);
        $stmt->bindParam(":material", $this->material);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":base_price", $this->base_price);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created_by", $this->created_by, PDO::PARAM_INT);

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

    /**
     * Updates the cutout_ids for a given sconce_id.
     * It adds new cutouts and removes ones that are no longer needed.
     *
     * @param int $sconce_id The ID of the sconce
     * @param array $cutout_ids The list of cutout IDs to keep
     */
    function updateCutouts($cutout_ids)
    {
        // Get the existing cutout IDs for this sconce
        $stmt = $this->con->prepare("SELECT cutout_id FROM rel_sconces_cutouts WHERE sconce_id = ?");
        $stmt->execute([$this->sconce_id]);
        $existing_cutouts = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Determine which cutout IDs need to be removed
        $to_remove = array_diff($existing_cutouts, $cutout_ids);

        // Determine which cutout IDs need to be added
        $to_add = array_diff($cutout_ids, $existing_cutouts);

        // Remove old cutouts
        if (!empty($to_remove)) {
            $placeholders = implode(',', array_fill(0, count($to_remove), '?'));
            $stmt = $this->con->prepare("DELETE FROM rel_sconces_cutouts WHERE sconce_id = ? AND cutout_id IN ($placeholders)");
            $stmt->execute(array_merge([$this->sconce_id], $to_remove));
        }

        // Add new cutouts
        if (!empty($to_add)) {
            $stmt = $this->con->prepare("INSERT INTO rel_sconces_cutouts (sconce_id, cutout_id) VALUES (?, ?)");
            foreach ($to_add as $cutout_id) {
                $stmt->execute([$this->sconce_id, $cutout_id]);
            }
        }
    }
}
