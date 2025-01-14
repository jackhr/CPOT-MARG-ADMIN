<?php

namespace App\Controllers;

use App\Config\Database;
use App\Helpers\GeneralHelper;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemAddOns;
use Exception;

class OrderController extends Controller
{
    private $orderModel;
    private $contactModel;
    private $orderItemModel;
    private $orderItemAddOnsModel;
    private $helper;
    private $dbConnection;

    public function __construct()
    {
        $database = new Database();
        $this->dbConnection = $database->getConnection();

        $this->orderModel = new Order($this->dbConnection);
        $this->contactModel = new Contact($this->dbConnection);
        $this->orderItemModel = new OrderItem($this->dbConnection);
        $this->orderItemAddOnsModel = new OrderItemAddOns($this->dbConnection);
        $this->helper = new GeneralHelper();
    }

    public function getAll()
    {
        $table = "orders";
        $override_query = "SELECT $table.*, contact.*, CONCAT(contact.first_name, ' ', contact.last_name) AS full_name 
            FROM $table
            LEFT JOIN contact_info contact ON $table.contact_id = contact.contact_id";
        $orders = $this->orderModel->readAll($override_query, "order_id");

        $order_items = $this->orderModel->DBRaw("SELECT * FROM order_items");

        foreach ($order_items as $order_item) {
            if (!is_null($order_item['sconce_id'])) {
                $sconce = $this->orderModel->DBRaw(
                    "SELECT sconces.*, sconce_images.image_url
                        FROM sconces
                        LEFT JOIN sconce_images ON sconces.primary_image_id = sconce_images.image_id
                    WHERE sconces.sconce_id = {$order_item['sconce_id']}"
                );
                $order_item['sconce'] = $sconce[0];
            }

            if (!is_null($order_item['cutout_id'])) {
                $cutout = $this->orderModel->DBRaw(
                    "SELECT cutouts.*, cutout_images.image_url
                        FROM cutouts
                        LEFT JOIN cutout_images ON cutouts.primary_image_id = cutout_images.image_id
                    WHERE cutouts.cutout_id = {$order_item['cutout_id']}"
                );
                $order_item['cutout'] = $cutout[0];
            }
            $order_id = $order_item['order_id'];

            if (isset($orders[$order_id]['order_items'])) {
                $orders[$order_id]['order_items'][] = $order_item;
                $orders[$order_id]['order_item_count']++;
            } else {
                $orders[$order_id]['order_items'] = [$order_item];
                $orders[$order_id]['order_item_count'] = 1;
            }
        }

        $this->helper->respondToClient($orders);
    }

    public function listOrders()
    {
        $logged_in_user = $_SESSION['user'];
        $this->view("admin/orders/list.php", [
            "user" => $logged_in_user,
            "title" => "Orders"
        ]);
    }

    public function updateStatus($order_id)
    {
        $inputData = file_get_contents('php://input');
        $data = json_decode($inputData, true);

        $this->orderModel->order_id = $order_id;
        $this->orderModel->previous_status = $data['current_status'];
        $this->orderModel->current_status = $data['new_status'];

        if ($this->orderModel->updateStatus()) {
            $status = 200;
            $message = "Order status updated successfully.";
            $updated_order = $this->orderModel->findById($order_id);
        } else {
            $status = 409;
            $message = "Error updating order status.";
        }

        $this->helper->respondToClient($updated_order, $status, $message);
    }

    public function create()
    {
        $new_order = [];
        $status = 200;
        $message = "Order created successfully";

        [
            "message" => $message_from_client,
            "total_amount" => $total_amount,
            "internal_notes" => $internal_notes,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "phone" => $phone,
            "address_1" => $address_1,
            "town_or_city" => $town_or_city,
            "state" => $state,
            "country" => $country,
            "order_items" => $order_items,
        ] = $_POST;

        try {
            // Begin transaction
            $this->dbConnection->beginTransaction();

            // Create contact
            $this->contactModel->first_name = $first_name;
            $this->contactModel->last_name = $last_name;
            $this->contactModel->email = $email;
            $this->contactModel->phone = $phone;
            $this->contactModel->address_1 = $address_1;
            $this->contactModel->town_or_city = $town_or_city;
            $this->contactModel->state = $state;
            $this->contactModel->country = $country;

            $contact_id = $this->contactModel->create();

            // Create order
            $this->orderModel->contact_id = $contact_id;
            $this->orderModel->message = $message_from_client;
            $this->orderModel->internal_notes = $internal_notes;
            $this->orderModel->total_amount = $total_amount;

            $order_id = $this->orderModel->create();

            // Create order items
            if (!empty($order_items) && is_array($order_items)) {
                foreach ($order_items as $item) {
                    $this->orderItemModel->order_id = $order_id;
                    $this->orderItemModel->item_type = $item['item_type'] ?? "sconce";
                    $this->orderItemModel->sconce_id = (!empty($item['sconce_id']) && $item['sconce_id'] !== "") ? $item['sconce_id'] : null;
                    $this->orderItemModel->cutout_id = (!empty($item['cutout_id']) && $item['cutout_id'] !== "") ? $item['cutout_id'] : null;
                    $this->orderItemModel->quantity = (int)$item['quantity'];
                    $this->orderItemModel->price = $item['price'];
                    $this->orderItemModel->description = $item['description'];
                    
                    // Get the last inserted order_item_id
                    $order_item_id = $this->orderItemModel->create();

                    // Insert add-ons for this order item if they exist
                    if (!empty($item['add_on_ids']) && is_array($item['add_on_ids'])) {                        
                        foreach ($item['add_on_ids'] as $add_on_id) {
                            $this->orderItemAddOnsModel->order_item_id = $order_item_id;
                            $this->orderItemAddOnsModel->add_on_id = $add_on_id;
                            $this->orderItemAddOnsModel->attachAddOnsToOrderItem();
                        }
                    }
                }
            }

            // Commit transaction
            $this->dbConnection->commit();

            // Fetch the newly created order
            $new_order = $this->orderModel->findById($order_id);
        } catch (Exception $e) {
            // Rollback transaction on failure
            $this->dbConnection->rollBack();
            $status = 500;
            $message = "Transaction failed: " . $e->getMessage();
        }

        $this->helper->respondToClient($new_order, $status, $message);
    }
}
