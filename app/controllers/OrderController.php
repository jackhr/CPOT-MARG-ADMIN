<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Order;

class OrderController extends Controller
{
    private $orderModel;
    private $helper;

    public function __construct()
    {
        $this->orderModel = new Order();
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
            $updated_cutout = $this->orderModel->findById($order_id);
        } else {
            $status = 409;
            $message = "Error updating cutout.";
        }

        $this->helper->respondToClient($updated_cutout, $status, $message);
    }
}
