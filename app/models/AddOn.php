<?php

namespace App\Models;

use PDO;

class AddOn extends Model
{

    public $add_on_id;
    public $name;
    public $price;
    public $description;
    public $desc_short;

    public function __construct(PDO $connection = null)
    {
        parent::__construct($connection);
        $this->table_name = "add_ons";
        $this->primary_key = "add_on_id";
    }
}
