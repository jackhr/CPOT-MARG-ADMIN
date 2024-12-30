<?php

namespace App\Models;

use PDO;

class Order extends Model
{
    public $order_id;
    public $contact_id;
    public $message;
    public $total_amount;
    public $internal_notes;
    public $order_type;
    public $previous_status;
    public $current_status;
    public $status_updated_at;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "orders";
        $this->primary_key = "order_id";
    }

    public function updateStatus() {
        $query = "UPDATE {$this->table_name} SET previous_status = :previous_status, current_status = :current_status WHERE order_id = :order_id";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->order_id = htmlspecialchars($this->order_id);
        $this->previous_status = htmlspecialchars($this->previous_status);
        $this->current_status = htmlspecialchars($this->current_status);

        // Bind parameters
        $stmt->bindParam(":order_id", $this->order_id, PDO::PARAM_INT);
        $stmt->bindParam(":previous_status", $this->previous_status, PDO::PARAM_STR);
        $stmt->bindParam(":current_status", $this->current_status, PDO::PARAM_STR);

        // Execute the query
        return $stmt->execute();
    }
}
