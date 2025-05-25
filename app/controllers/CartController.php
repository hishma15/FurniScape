<?php 

require_once 'C:\xampp\htdocs\FurniScape\config\database.php';
// Fetch products details from Product.php
require_once 'C:\xampp\htdocs\FurniScape\app\models\Product.php';

// Sesion-based CRUD for cart

class CartController{

    private $db;
    private $product;

    public function __construct() {
    $database = new Database();
    $this->db = $database->connect();
    $this->product = new Product($this->db);
    }

    public function addToCart($productId){
        if(!$productId) {
            $_SESSION['error'] = "Product not found.";
            header("Location: " . $_SERVER['HTTP_REFERER']);  // After adding an item to the cart the customer will remain on the same page. 
            // echo "Product Not Found.";
            exit;
        }

        // Fetch product details from the database
        $product = $this->product->getProductById($productId);

        if (!$product) {
            $_SESSION['error'] = "Product not found in database.";
            // echo "Product not found in database.";
            header("Location: " . $_SERVER['HTTP_REFERER']);  //After adding an item to the cart the customer will remain on the same page. 
            exit;
        }

        // Initializing the cart if not already
        if (!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
        }

        // Chack if the products already in cart
        if (isset($_SESSION['cart'][$productId])){
            // $_SESSION['cart'][$productId]['quantity'] += 1;
            $_SESSION['error'] = "Product already in cart.";

        }else {
            $_SESSION['cart'][$productId] =[
                'product_id' => $product['product_id'],
                'productImage' => $product['productImage'] ?? '',
                'product_name' => $product['product_name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
            $_SESSION['success'] = "Product added to cart!";

        }
            // header("Location: /FurniScape/app/views/customer/cart.php");
            
            header("Location: " . $_SERVER['HTTP_REFERER']); // After adding an item to the cart the customer will remain on the same page. 
            exit;
    }

    public function viewCart(){
        require_once 'C:\xampp\htdocs\FurniScape\app\views\customer\cart.php';
    }

    public function removeItem($productId) {
        if  (isset($_SESSION['cart'][$productId])){
            unset($_SESSION['cart'][$productId]);
        }
        header("Location: /FurniScape/app/views/customer/cart.php");

    }

    public function clearCart(){
        unset($_SESSION['cart']);
        header("Location: /FurniScape/app/views/customer/cart.php");
    }

    // Update quantity functionality
    public function updateQuantity($productId, $action) {
        if (isset($_SESSION['cart'][$productId])) {
            if ($action === 'increase') {
                $_SESSION['cart'][$productId]['quantity'] += 1;
            } elseif ($action === 'decrease') {
                if ($_SESSION['cart'][$productId]['quantity'] > 1) {
                    $_SESSION['cart'][$productId]['quantity'] -= 1;
                } else {
                unset($_SESSION['cart'][$productId]);
                }
            }
        }
        header("Location: /FurniScape/app/views/customer/cart.php");
        exit;
    }

    public function proceedToCheckout() {
        if (empty($_SESSION['cart'])) {
            header("Location: /FurniScape/app/views/customer/cart.php");
            exit;
        }
        require_once 'C:\xampp\htdocs\FurniScape\app\views\customer\checkout.php';
    }


}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Controller instantiation
$cart = new CartController;

// Route the request based on query parameters or form action

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'addToCart':
            $cart->addToCart($_GET['id']);
            break;
        case 'view':
            $cart->viewCart();
            break;
        case 'remove':
            $cart->removeItem($_GET['id']);
            break;
        case 'clear':
            $cart->clearCart();
            break;
        case 'checkout': 
            $cart->proceedToCheckout();
            break;
    }
}


// For Quantity updation routing block
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['product_id'])) {
    $cart->updateQuantity($_POST['product_id'], $_POST['action']);
}


?>
