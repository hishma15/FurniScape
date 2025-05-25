<?php

// session_start();

// require_once '../config/database.php';
// require_once '../models/User.php';
require_once 'C:\xampp\htdocs\FurniScape\config\database.php';
require_once 'C:\xampp\htdocs\FurniScape\app\models\User.php';

class AuthController{
    private $db;
    private $user;
    
    public function __construct(){
        $database =new Database();
        $this->db=$database->connect();  //Initializing the database connection
        $this->user = new User($this->db); //Pass the connection to the User model
    }

    public function register(){
        // Handle register
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Checks the password match
            if ($_POST['password'] !== $_POST['confirm-password']) {
                $_SESSION['error'] = "Passwords do not match.";
                header("Location: /FurniScape/app/views/customer/customerRegister.php");
                exit;
            
            }

            //Connect to database
            $database=new DATABASE();
            $db=$database->connect();

            //Create Customer object
            $user=new User($db);
            $user->first_name = $_POST['first-name'];
            $user->last_name = $_POST['last-name'];
            $user->email = $_POST['email'];
            $user->phone = $_POST['phone'] ?? null;      // optional for admin
            $user->address = $_POST['address'] ?? null;  // optional for admin
            $user->setPassword($_POST['password']);

            //Try to register
            if($user->register()){
                $_SESSION['success'] = "Registration successfull. Please Login.";
                // header("Location: /furniscape/app/views/customer/auth.php?form=login");
                header("Location: /furniscape/app/views/customer/customerLogin.php");
                exit;
            }
            else{
                $_SESSION['error'] = "Email already exists or registration failed.";
                // header("Location: /furniscape/app/views/customer/auth.php?form=register");
                header("Location: /furniscape/app/views/customer/customerRegister.php");
                exit;
            }

            //Redirect
            header("Location: /FurniScape/app/views/customer/customerRegister.php");
            exit;
        }
    }

    // Handle login
    public function login(){
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // var_dump($_POST);  // Check form data
            // exit;
        $email = $_POST['email'];
        $password = $_POST['password'];

        $userData = $this->user->findByEmail($email);

        if ($userData && $this->user->verifyPassword($password, $userData['password'])) {
            $_SESSION['user'] = [
                'id' => $userData['id'],
                'email' => $userData['email'],
                'role' => $userData['role'],
                'first_name' => $userData['first_name']
            ];

            // Redirect based on role
            if ($userData['role'] === 'customer') {
                $_SESSION['success'] = "Login successful.";
                header("Location: /FurniScape/app/views/customer/home.php");
                exit;
            } else {
                $_SESSION['error'] = "Invalid email or password.";
                header("Location: /FurniScape/app/views/customer/customerLogin.php");
                exit;
            }
            exit;
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: /FurniScape/app/views/customer/customerLogin.php");
            exit;
            }

        } 
    }

    //  To view Profile
    // public function viewProfile() {
    //     $userId = $_SESSION['user']['id'];
    //     $userData = $this->user->findById($userId);

    // return $userData; 
    // }

//     public function login(){
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     var_dump($_POST);  // Show form data

//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     $userData = $this->user->findByEmail($email);

//     var_dump($userData); // Show fetched user from DB

//     if ($userData) {
//         var_dump(password_verify($password, $userData['password']));
//     }

//     exit;
// }
//     }
    

}

?>