<?php

require_once 'C:\xampp\htdocs\FurniScape\config\database.php';
require_once 'C:\xampp\htdocs\FurniScape\app\models\Product.php';
require_once 'C:\xampp\htdocs\FurniScape\app\models\Category.php';

class ProductController{

    private $db;
    private $product;

    public function __construct() {
    $database = new Database();
    $this->db = $database->connect();
    $this->product = new Product($this->db);

    // //  TO search functionality
    // $search = $_GET['search'] ?? null;
    // if ($search) {
    //     $products = $product->search($search);
    // } else {
    //     $products = $product->getAll();  // Or getAvailable().
    // }


    }

    // CREATE 
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->product->product_name = $_POST['product_name'];
            $this->product->no_of_stock = $_POST['no_of_stock'];
            $this->product->price = $_POST['price'];
            $this->product->type = $_POST['type'];
            $this->product->description = $_POST['description'];
            $this->product->category_id = $_POST['category_id'];
            $this->product->is_featured = isset($_POST['is_featured']) ? 1 : 0;

            // Image upload
            if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === 0) {
                $imageName = time() . '_' . $_FILES['productImage']['name'];
                $destination = 'C:\xampp\htdocs\FurniScape\public\images\\' . $imageName;
                move_uploaded_file($_FILES['productImage']['tmp_name'], $destination);
                $this->product->productImage = $imageName;
            } else {
                $this->product->productImage = null;
            }

            if ($this->product->create()) {
                $_SESSION['success'] = "Product created successfully.";
            } else {
                $_SESSION['error'] = "Failed to create product.";
            }

            header("Location: /FurniScape/app/views/admin/productManagement.php");
            exit;
        }
    }
    
    // UPDATE
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->product->product_id = $_POST['product_id'];
            $this->product->product_name = $_POST['product_name'];
            $this->product->no_of_stock = $_POST['no_of_stock'];
            $this->product->price = $_POST['price'];
            $this->product->type = $_POST['type'];
            $this->product->description = $_POST['description'];
            $this->product->category_id = $_POST['category_id'];
            $this->product->is_featured = isset($_POST['is_featured']) ? 1 : 0;

            if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === 0) {
                $imageName = time() . '_' . $_FILES['productImage']['name'];
                $destination = 'C:\xampp\htdocs\FurniScape\public\images\\' . $imageName;
                move_uploaded_file($_FILES['productImage']['tmp_name'], $destination);
                $this->product->productImage = $imageName;
            } else {
                $this->product->productImage = $_POST['existingImage'] ?? null;
            }

            if ($this->product->update()) {
                $_SESSION['success'] = "Product updated.";
            } else {
                $_SESSION['error'] = "Update failed.";
            }

            header("Location: /FurniScape/app/views/admin/productManagement.php");
            exit;
        }
    }

    // DELETE
    public function delete() {
        if (isset($_GET['delete_id'])) {
            $this->product->product_id = $_GET['delete_id'];

            if ($this->product->delete()) {
                $_SESSION['success'] = "Product deleted.";
            } else {
                $_SESSION['error'] = "Delete failed.";
            }

            header("Location: /FurniScape/app/views/admin/productManagement.php");
            exit;
        }
    }

    //Fetch products for the view
    public function fetchProducts(){
        return $this->product->getAll(); //fetch all products
    }

    public function getProductByCategory($categoryId){
        return $this->product->getByCategory($categoryId);
    }

    public function getFeaturedProducts(){
        return $this->product->getFeaturedProducts();
    }



}



// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Controller instantiation
$controller = new ProductController();

// Route the request based on query parameters or form action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'create') {
        $controller->create();
    } elseif ($action === 'update') {
        $controller->update();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $controller->delete();
}



?>