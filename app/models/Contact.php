<?php

namespace App\Models;

use PDO;

class Contact extends Model
{

    public $contact_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $address_1;
    public $address_2;
    public $town_or_city;
    public $state;
    public $country;
    public $created_at;
    public $updated_at;

    public function __construct(PDO $connection = null)
    {
        parent::__construct($connection);
        $this->table_name = "contact_info";
        $this->primary_key = "contact_id";
    }

    public function create()
    {
        $query = "INSERT INTO {$this->table_name} SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, address_1 = :address_1, town_or_city = :town_or_city, state = :state, country = :country";
        $stmt = $this->con->prepare($query);

        // Sanitize input
        $this->first_name = htmlspecialchars($this->first_name);
        $this->last_name = htmlspecialchars($this->last_name);
        $this->email = htmlspecialchars($this->email);
        $this->phone = htmlspecialchars($this->phone);
        $this->address_1 = htmlspecialchars($this->address_1);
        $this->town_or_city = htmlspecialchars($this->town_or_city);
        $this->state = htmlspecialchars($this->state);
        $this->country = htmlspecialchars($this->country);

        // Bind parameters
        $stmt->bindParam(":first_name", $this->first_name, PDO::PARAM_STR);
        $stmt->bindParam(":last_name", $this->last_name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $this->phone, PDO::PARAM_STR);
        $stmt->bindParam(":address_1", $this->address_1, PDO::PARAM_STR);
        $stmt->bindParam(":town_or_city", $this->town_or_city, PDO::PARAM_STR);
        $stmt->bindParam(":state", $this->state, PDO::PARAM_STR);
        $stmt->bindParam(":country", $this->country, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        return $this->con->lastInsertId();
    }
}
