<?php

namespace App\Models;

use PDO;

class OrderItemAddOns extends Model
{

    public $order_item_add_on_id;
    public $order_item_id;
    public $add_on_id;
    public $add_on_name;
    public $add_on_price;
    public $quantity;

    public function __construct(PDO $connection = null)
    {
        parent::__construct($connection);
        $this->table_name = "order_item_add_ons";
        $this->primary_key = "order_item_add_on_id";
    }

    public function attachAddOnsToOrderItem()
    {
        $query = "INSERT INTO order_item_add_ons (order_item_id, add_on_id, add_on_name, add_on_price)
            SELECT :order_item_id, ao.add_on_id, ao.name, ao.price
            FROM add_ons ao
            WHERE ao.add_on_id = :add_on_id;
        ";

        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->order_item_id = htmlspecialchars($this->order_item_id);
        $this->add_on_id = htmlspecialchars($this->add_on_id);

        // Bind parameters
        $stmt->bindParam(":order_item_id", $this->order_item_id, PDO::PARAM_INT);
        $stmt->bindParam(":add_on_id", $this->add_on_id, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        return $this->con->lastInsertId();
    }
}
