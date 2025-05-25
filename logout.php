<?php
session_start();

// Decide redirect path based on user role
$redirect = "/FurniScape/app/views/customer/customerLogin.php";

if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
    $redirect = "/FurniScape/app/views/admin/login.php";
}

// Destroy session
$_SESSION = [];
session_unset();  // Clear all session variables
session_destroy();  // Destroy the session

// Start session again to set flash message
session_start();
$_SESSION['success'] = "You have been logged out successfully.";

// Redirect to appropriate login page
header("Location: $redirect");
exit;

// session_start();
// session_unset(); // Clear all session variables
// session_destroy(); // Destroy the session

// // Redirect to login page (adjust path as needed)
// // header("Location: /FurniScape/app/views/customer/customerLogin.php");
// // exit;


?>