<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
?>

<?php 

// session_start();

require_once '../config/database.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/AdminController.php';

//Get theroute from the URL
$route = $_GET['route'] ?? '';

// Initialize controller
$auth = new AuthController();
$admin = new AdminController();


switch($route){
    case 'register':
        $auth->register();
        break;
    case 'login':
        $auth->login();
        break;
    case 'adminLogin':
        $admin ->login();
        break;
    case 'verifyOTP':
        $admin->verifyOTP();
        break;
    default:
        echo "404 - Page not found.";
}


?>


<!-- 
// $admin = new AdminController();

//Get theroute from the URL

// $route = $_GET['route'] ?? '';
// // $routeAdmin = $_GET['routeAdmin'] ?? '';

// // Route handling

// //For customer
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if ($route === 'register') {
//         $auth->register();
//     } elseif ($route === 'login') {
//         $auth->login(); 
//     // } elseif ($route === 'adminLogin') {
//     //     $auth->login(); 
//     // } elseif ($routeAdmin === 'login') {
//     //     $auth->login(); 
//      }
//      else{
//         echo "Invalid route.";
//      }
// } else {
//     echo "Invalid request method.";
// } -->



<!-- // For POST requests, handle login and register
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if ($route === 'register') {
//         $auth->register();
//     } elseif ($route === 'login') {
//         $auth->login();
//     } else {
//         echo "Invalid POST route.";
//     }
// } else {
//     // For GET requests, handle routes like admin dashboard
//     if ($route === 'adminDashboard') {
//         $admin->Dashboard();
//     } elseif ($route === 'login') {
//         require_once '../app/views/admin/login.php';  // Render login page if 'login' route is requested
//     } elseif ($route === 'logout') {
//         session_destroy();
//         header("Location: /FurniScape/app/views/customer/customerLogin.php");
//         exit;
//     } else {
//         echo "404 - Page not found.";
//     }
// } -->


<!-- 
// //For admin
// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     if ($route === 'adminDashboard') {
//         $admin->Dashboard();
//     // } elseif ($route === 'customerHome'){
//     //     require_once '../app/views/customer/home.php';
//     } else {
//         echo "Invalid GET route.";
//     }
// }

// // Route handling — properly grouped by method
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if ($route === 'register') {
//         $auth->register();
//     } elseif ($route === 'login') {
//         $auth->login();
//     } else {
//         echo "Invalid POST route: '$route'";
//     }
// } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     if ($route === 'login') {
//         $auth->login();
//     } elseif ($route === 'adminDashboard') {
//         $admin->dashboard();
//     } else {
//         echo "Invalid GET route: '$route'";
//     }
// } else {
//     echo "Unsupported request method: " . $_SERVER['REQUEST_METHOD'];
// } -->