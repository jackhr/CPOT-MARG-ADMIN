<?php

namespace App\Models;

use App\Helpers\GeneralHelper;
use PDO;

class SconceImage extends Model
{

    public $image_id;
    public $sconce_id;
    public $image_url;
    public $created_at;
    public $updated_at;

    public $helper;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "sconce_images";
        $this->primary_key = "image_id";
        $this->helper = new GeneralHelper();
    }

    public function update()
    {
        $query = "UPDATE {$this->table_name} SET sconce_id = :sconce_id, image_url = :image_url WHERE image_id = :image_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->sconce_id = htmlspecialchars($this->sconce_id);
        $this->image_url = htmlspecialchars($this->image_url);
        $this->image_id = htmlspecialchars($this->image_id);

        // Bind parameters
        $stmt->bindParam(":sconce_id", $this->sconce_id, PDO::PARAM_INT);
        $stmt->bindParam(":image_url", $this->image_url, PDO::PARAM_STR);
        $stmt->bindParam(":image_id", $this->image_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function create()
    {
        $query = "INSERT INTO {$this->table_name} SET sconce_id = :sconce_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->sconce_id = htmlspecialchars($this->sconce_id);

        // Bind parameters
        $stmt->bindParam(":sconce_id", $this->sconce_id, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // return the id just created
        return $this->con->lastInsertId();
    }

    public function findByImageId($image_id)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE image_id = :image_id";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":image_id", $image_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findBySconceId($sconce_id)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE sconce_id = :sconce_id";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":sconce_id", $sconce_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
