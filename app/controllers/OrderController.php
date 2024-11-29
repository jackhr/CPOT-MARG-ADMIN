<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Order;
use Exception;

class OrderController extends Controller
{
    private $orderModel;
    private $helper;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->helper = new GeneralHelper();
    }

    public function listOrders()
    {
        $logged_in_user = $_SESSION['user'];
        $table = "orders";
        $override_query = "SELECT $table.*, contact.first_name, contact.last_name, contact.email 
            FROM $table
            LEFT JOIN contact_info contact ON $table.contact_id = contact.contact_id";
        $orders = $this->orderModel->readAll($override_query, "order_id");

        $order_items = $this->orderModel->DBRaw("SELECT * FROM order_items");

        foreach ($order_items as $order_item) {
            if (!is_null($order_item['sconce_id'])) {
                $sconce = $this->orderModel->DBRaw("SELECT * FROM sconces WHERE sconce_id = {$order_item['sconce_id']}");
                $order_item['sconce'] = $sconce[0];
            }

            if (!is_null($order_item['cutout_id'])) {
                $cutout = $this->orderModel->DBRaw("SELECT * FROM cutouts WHERE cutout_id = {$order_item['cutout_id']}");
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

        $this->view("admin/orders/list.php", [
            "user" => $logged_in_user,
            "orders" => $orders,
            "title" => "Orders"
        ]);
    }
}
