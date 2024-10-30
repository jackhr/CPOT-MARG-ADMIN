<?php

namespace App\Models;

class Sconce extends Model
{
    public $sconce_id;
    public $name;
    public $slug;
    public $dimensions;
    public $material;
    public $color;
    public $weight;
    public $base_price;
    public $stock_quantity;
    public $status;
    public $installation_type;
    public $style;
    public $image_url;
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

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "sconces";
    }
}
