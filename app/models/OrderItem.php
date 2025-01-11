<?php

namespace App\Models;

use PDO;

class OrderItem extends Model
{
    public $order_item_id;
    public $order_id;
    public $item_type;
    public $sconce_id;
    public $cutout_id;
    public $ceramic_id;
    public $finish_option_id;
    public $cover_option_id;
    public $is_covered;
    public $is_glazed;
    public $quantity;
    public $price;
    public $description;
    public $created_at;
    public $updated_at;

    public function __construct(PDO $connection = null)
    {
        parent::__construct($connection);
        $this->table_name = "order_items";
        $this->primary_key = "order_item_id";
    }

    public function create()
    {
        $sconce_id_is_set = isset($this->sconce_id);
        $cutout_id_is_set = isset($this->cutout_id);

        $query = "INSERT INTO {$this->table_name} SET 
            order_id = :order_id, 
            item_type = :item_type" . 
            ($sconce_id_is_set ? ", sconce_id = :sconce_id" : ", sconce_id = NULL") . 
            ($cutout_id_is_set ? ", cutout_id = :cutout_id" : ", cutout_id = NULL") . 
            ", is_covered = :is_covered, 
            is_glazed = :is_glazed, 
            quantity = :quantity, 
            price = :price, 
            description = :description
        ";

        $stmt = $this->con->prepare($query);


        // Sanitize input
        $this->order_id = htmlspecialchars($this->order_id);
        $this->item_type = htmlspecialchars($this->item_type);
        if ($sconce_id_is_set) $this->sconce_id = htmlspecialchars($this->sconce_id);
        if ($cutout_id_is_set) $this->cutout_id = htmlspecialchars($this->cutout_id);
        $this->is_covered = htmlspecialchars($this->is_covered);
        $this->is_glazed = htmlspecialchars($this->is_glazed);
        $this->quantity = htmlspecialchars($this->quantity);
        $this->price = htmlspecialchars($this->price);
        $this->description = htmlspecialchars($this->description);

        // Bind parameters
        $stmt->bindParam(":order_id", $this->order_id, PDO::PARAM_INT);
        $stmt->bindParam(":item_type", $this->item_type, PDO::PARAM_STR);
        if ($sconce_id_is_set) $stmt->bindParam(":sconce_id", $this->sconce_id, PDO::PARAM_INT);
        if ($cutout_id_is_set) $stmt->bindParam(":cutout_id", $this->cutout_id, PDO::PARAM_INT);
        $stmt->bindParam(":is_covered", $this->is_covered, PDO::PARAM_BOOL);
        $stmt->bindParam(":is_glazed", $this->is_glazed, PDO::PARAM_BOOL);
        $stmt->bindParam(":quantity", $this->quantity, PDO::PARAM_INT);
        $stmt->bindParam(":price", $this->price, PDO::PARAM_INT);
        $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);


        // Execute the query
        $stmt->execute();

        return $this->con->lastInsertId();
    }
}
