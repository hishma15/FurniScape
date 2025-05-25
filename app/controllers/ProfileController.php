<?php

require_once 'C:\xampp\htdocs\FurniScape\config\database.php';
require_once 'C:\xampp\htdocs\FurniScape\app\models\User.php';

class ProfileController {
    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->userModel = new User($this->db);
    }

    public function updateUser() {
        $userId = $_SESSION['user']['id']; // Make sure to get the ID before using it

        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'email' => $_POST['email'],
        ];

        // Call model to update
        $result = $this->userModel->updateProfile($userId, $data);

        if ($result === "email_exists") {
            $_SESSION['error'] = "Email is already used by another account.";
        } elseif ($result === true) {
            $_SESSION['success'] = "Profile updated successfully.";
            $_SESSION['user']['email'] = $data['email']; // Optional: update session
        } else {
            $_SESSION['error'] = "Failed to update profile.";
        }

        header("Location: /FurniScape/app/views/customer/viewOrder.php");
        exit;
    }

    // Fetch current logged-in user data
    public function getCurrentUser() {
        if (!isset($_SESSION['user']['id'])) {
            return null;
        }

        return $this->userModel->findById($_SESSION['user']['id']);
    }

    //  To view Profile
    public function viewProfile() {
        $userId = $_SESSION['user']['id'];
        $userData = $this->userModel->findById($userId);

    return $userData; 
    }

    // Update profile logic
    // public function updateProfile($data) {
    //     $userId = $_SESSION['user']['id'];

    //     return $this->userModel->updateProfile($userId, $data);
    // }
}



// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = new ProfileController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'update_profile')  {
    $controller->updateUser();
}

?>