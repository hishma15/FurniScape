<?php

require_once 'C:\xampp\htdocs\FurniScape\config\database.php';
require_once 'C:\xampp\htdocs\FurniScape\app\models\Order.php';
require_once 'C:\xampp\htdocs\FurniScape\app\models\User.php';

class OrderController{
    private $db;
    private $order;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->order = new Order($this->db);
        $this->user = new User($this->db);
    }    

        // Handle Checkout Form Submission
    public function placeOrderWithCheckout() {

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
            header("Location: /FurniScape/app/views/customer/customerLogin.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkoutSubmit'])) {
            $userId = $_SESSION['user']['id'];

            // Update user info (name, email, phone)
            // $this->user->updateUserDetails(
            //     $userId,
            //     $_POST['first_name'],
            //     $_POST['last_name'],
            //     $_POST['email'],
            //     $_POST['phone']
            // );

            // Extract delivery address
            $home_no = $_POST['home_no'] ?? '';
            $street = $_POST['street'] ?? '';
            $city = $_POST['city'] ?? '';
            $delivery_date = $_POST['delivery_date'] ?? date('Y-m-d');

            $cartItems = $_SESSION['cart'] ?? [];

             // Calculate totals
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $deliveryCharge = 200;
            $tax = $subtotal * 0.10;
            $total = $subtotal + $deliveryCharge + $tax;


            if (!empty($cartItems)) {
                $orderId = $this->order->place($userId, $cartItems, $home_no, $street, $city, $delivery_date, $total);

                if ($orderId) {
                    unset($_SESSION['cart']);
                    $_SESSION['success'] = "Order placed successfully!";
                    header("Location: /FurniScape/app/views/customer/orderSuccess.php");
                    exit;
                }
            }

            $_SESSION['error'] = "Failed to place order.";
            header("Location: /FurniScape/app/views/customer/checkout.php");
        }
    }    

    // Get user info to autofill the form
    public function getUserDetails() {

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
            header("Location: /FurniScape/app/views/customer/customerLogin.php");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        return $this->user->findById($userId);
    }    

    // ADmin view orders
    public function listOrders() {
        return $this->order->getAllOrders();
    }

    public function updateOrder($orderId, $status, $delivery_date) {
        return $this->order->updateOrder($orderId, $status, $delivery_date);
    }


    public function handleOrderUpdate() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $orderId = $_POST['order_id'];
        $status = $_POST['status'];
        $delivery_date = $_POST['delivery_date'];

        $result = $this->updateOrder($orderId, $status, $delivery_date);

        if ($result) {
            $_SESSION['success'] = "Order status updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update order status.";
        }

        // Redirect after update to avoid form resubmission
        header("Location: /FurniScape/app/views/admin/orderManagement.php");
        exit;
        }
    }

    public function getOrderItems($orderId) {
        return $this->order->getOrderItems($orderId);
    }

    public function getOrdersByUserId($userId) {
    return $this->order->getByUserId($userId);
    }

    public function DeleteUserOrder($orderId) {
        
        $userId = $_SESSION['user']['id'];

        // Check if user can delete this order
        if ($this->order->canUserDeleteOrder($orderId, $userId)) {
            $deleted = $this->order->deleteOrder($orderId);

            if ($deleted) {
                $_SESSION['success'] = "Order deleted successfully.";
            } else {
                $_SESSION['error'] = "Failed to delete order.";
            }
        } else {
            $_SESSION['error'] = "You can only delete pending orders that belong to you.";
        }

        header("Location: /FurniScape/app/views/customer/viewOrder.php");
        exit;

    }


}

// Routing
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = new OrderController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'place_order') {
    $controller->placeOrderWithCheckout();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    $controller->DeleteUserOrder($orderId);
}

?>