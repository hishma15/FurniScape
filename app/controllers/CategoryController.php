
<!-- To figureout the error -->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php

require_once 'C:\xampp\htdocs\FurniScape\config\database.php';
require_once 'C:\xampp\htdocs\FurniScape\app\models\Category.php';

class CategoryController{
    private $db;
    private $category;

    public function __construct() {
    $database = new Database();
    $this->db = $database->connect();
    $this->category = new Category($this->db);
    }
    
    // CREATE
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->category->category_name = $_POST['category_name'];
            $this->category->category_desc = $_POST['category_desc'];

            // Image upload
            if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === 0) {
                $imageName = time() . '_' . $_FILES['category_image']['name'];
                $destination = 'C:\xampp\htdocs\FurniScape\public\images\\' . $imageName;
                move_uploaded_file($_FILES['category_image']['tmp_name'], $destination);
                $this->category->category_image = $imageName;
            } else {
                $this->category->category_image = null;
            }

            if ($this->category->create()) {
                $_SESSION['success'] = "Category created.";
            } else {
                $_SESSION['error'] = "Failed to create category.";
            }

            header("Location: /FurniScape/app/views/admin/contentManagement.php");
            exit;
        }
    }

    // UPDATE
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->category->category_id = $_POST['category_id'];
            $this->category->category_name = $_POST['category_name'];
            $this->category->category_desc = $_POST['category_desc'];

            // Image Update
            if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === 0) {
                $imageName = time() . '_' . $_FILES['category_image']['name'];
                $destination = 'C:\xampp\htdocs\FurniScape\public\images\\' . $imageName;
                move_uploaded_file($_FILES['category_image']['tmp_name'], $destination);
                $this->category->category_image = $imageName;
            } else {
                $this->category->category_image = $_POST['existingImage'] ?? null;
            }


            if ($this->category->update()) {
                $_SESSION['success'] = "Category updated.";
            } else {
                $_SESSION['error'] = "Update failed.";
            }

            header("Location: /FurniScape/app/views/admin/contentManagement.php");
            exit;
        }
    }

    // DELETE
    public function delete() {
        if (isset($_GET['delete_id'])) {
            $this->category->category_id = $_GET['delete_id'];

            if ($this->category->delete()) {
                $_SESSION['success'] = "Category deleted.";
            } else {
                $_SESSION['error'] = "Delete failed.";
            }

            header("Location: /FurniScape/app/views/admin/contentManagement.php");
            exit;
        }
    }

    // Fetch all categories
    public function fetchCategories() {
        return $this->category->getAll();
    }

    // Get category by id
    public function getCategoryById($categoryId) {
        return $this->category->getById($categoryId);
    }


}


// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Controller instantiation
$controller = new CategoryController();

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


// $controller = new CategoryController();

// if (isset($_GET['action'])) {
//     switch ($_GET['action']) {
//         case 'create':
//             $controller->create();
//             break;
//         case 'update':
//             $controller->update();
//             break;
//         case 'delete':
//             $controller->delete();
//             break;
//         default:
//             echo "Invalid action.";
//             break;
//     }
// }
?>