<?php

namespace App\Models;

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
}
