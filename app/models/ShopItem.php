<?php

namespace App\Models;

use App\Helpers\GeneralHelper;
use PDO;

class ShopItem extends Model
{
    public $shop_item_id;
    public $primary_image_id;
    public $name;
    public $artist;
    public $dimensions;
    public $material;
    public $color;
    public $price;
    public $status;
    public $image_url;
    public $description;
    public $showing_on_site;
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
        $this->table_name = "shop_items";
        $this->primary_key = "shop_item_id";
        $this->helper = new GeneralHelper();
    }

    public function updatePrimaryImg()
    {
        $query = "UPDATE {$this->table_name} SET primary_image_id = :primary_image_id WHERE shop_item_id = :shop_item_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->shop_item_id = htmlspecialchars($this->shop_item_id);
        $this->primary_image_id = htmlspecialchars($this->primary_image_id);

        // Bind parameters
        $stmt->bindParam(":primary_image_id", $this->primary_image_id, PDO::PARAM_INT);
        $stmt->bindParam(":shop_item_id", $this->shop_item_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function restore()
    {
        $query = "UPDATE {$this->table_name} SET deleted_at = NULL, `status` = 'active' WHERE shop_item_id = :shop_item_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->shop_item_id = htmlspecialchars($this->shop_item_id);

        // Bind parameters
        $stmt->bindParam(":shop_item_id", $this->shop_item_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function update()
    {
        $query = "UPDATE {$this->table_name} SET name = :name, dimensions = :dimensions, material = :material, artist = :artist, color = :color, price = :price, status = :status, description = :description, showing_on_site = :showing_on_site, updated_by = :updated_by WHERE shop_item_id = :shop_item_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->shop_item_id = htmlspecialchars($this->shop_item_id);
        $this->name = htmlspecialchars($this->name);
        $this->dimensions = htmlspecialchars($this->dimensions);
        $this->material = htmlspecialchars($this->material);
        $this->artist = htmlspecialchars($this->artist);
        $this->color = htmlspecialchars($this->color);
        $this->price = htmlspecialchars($this->price);
        $this->status = htmlspecialchars($this->status);
        $this->description = htmlspecialchars($this->description);
        $this->showing_on_site = htmlspecialchars($this->showing_on_site);
        $this->updated_by = htmlspecialchars($this->updated_by);
        
        // Bind parameters
        $stmt->bindParam(":shop_item_id", $this->shop_item_id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":dimensions", $this->dimensions);
        $stmt->bindParam(":material", $this->material);
        $stmt->bindParam(":artist", $this->artist);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":showing_on_site", $this->showing_on_site, PDO::PARAM_BOOL);
        $stmt->bindParam(":updated_by", $this->updated_by, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function create()
    {
        $query = "INSERT INTO {$this->table_name} SET name = :name, dimensions = :dimensions, material = :material, artist = :artist, color = :color, price = :price, status = :status, description = :description, showing_on_site = :showing_on_site, created_by = :created_by";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->name = htmlspecialchars($this->name);
        $this->dimensions = htmlspecialchars($this->dimensions);
        $this->material = htmlspecialchars($this->material);
        $this->artist = htmlspecialchars($this->artist);
        $this->color = htmlspecialchars($this->color);
        $this->price = htmlspecialchars($this->price);
        $this->status = htmlspecialchars($this->status);
        $this->description = htmlspecialchars($this->description);
        $this->showing_on_site = htmlspecialchars($this->showing_on_site);
        $this->created_by = htmlspecialchars($this->created_by);

        // Bind parameters
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":dimensions", $this->dimensions);
        $stmt->bindParam(":material", $this->material);
        $stmt->bindParam(":artist", $this->artist);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":showing_on_site", $this->showing_on_site, PDO::PARAM_BOOL);
        $stmt->bindParam(":created_by", $this->created_by, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    // Method to find an item by name
    /**
     * @return ShopItem
     */
    public function findByName($name)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE name = :name";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
