<?php

namespace App\Models;

use App\Helpers\GeneralHelper;
use PDO;

class CutoutImage extends Model
{

    public $image_id;
    public $cutout_id;
    public $image_url;
    public $created_at;
    public $updated_at;

    public $helper;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "cutout_images";
        $this->primary_key = "image_id";
        $this->helper = new GeneralHelper();
    }

    public function update()
    {
        $query = "UPDATE {$this->table_name} SET cutout_id = :cutout_id, image_url = :image_url WHERE image_id = :image_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->cutout_id = htmlspecialchars($this->cutout_id);
        $this->image_url = htmlspecialchars($this->image_url);
        $this->image_id = htmlspecialchars($this->image_id);

        // Bind parameters
        $stmt->bindParam(":cutout_id", $this->cutout_id, PDO::PARAM_INT);
        $stmt->bindParam(":image_url", $this->image_url, PDO::PARAM_STR);
        $stmt->bindParam(":image_id", $this->image_id, PDO::PARAM_INT);

        // Execute the query
        return $stmt->execute();
    }

    public function create()
    {
        $query = "INSERT INTO {$this->table_name} SET cutout_id = :cutout_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->cutout_id = htmlspecialchars($this->cutout_id);
        // $this->image_url = htmlspecialchars($this->image_url);

        // Bind parameters
        $stmt->bindParam(":cutout_id", $this->cutout_id, PDO::PARAM_INT);
        // $stmt->bindParam(":image_url", $this->image_url, PDO::PARAM_STR);

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

    public function findByCutoutId($cutout_id)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE cutout_id = :cutout_id";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":cutout_id", $cutout_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
