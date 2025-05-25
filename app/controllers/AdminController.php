<?php 

require_once 'C:\xampp\htdocs\FurniScape\config\database.php';
require_once 'C:\xampp\htdocs\FurniScape\app\models\User.php';
require_once 'C:\xampp\htdocs\FurniScape\app\models\Order.php';


class AdminController {

    private $db;
    private $user;
    
    private $order;
    
    public function __construct(){
        $database = new Database();
        $this->db = $database->connect();
        $this->user = new User($this->db);
        
        $this->order = new Order($this->db);
    }

        public function login() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Fetch user data from the database
            $userData = $this->user->findByEmail($email);

            if ($userData && $this->user->verifyPassword($password, $userData['password']) && $userData['role'] === 'admin') {


                // adding 2-factor authentication *
                // * step-1 --> store user temporarily until OTP verification
                $_SESSION['pending_admin'] = [
                    'id' => $userData['id'],
                    'email' => $userData['email'],
                    'role' => $userData['role'],
                    'first_name' => $userData['first_name']
                ];

                //  * step-2 --> Generate OTP and expiration time
                $otp = rand(100000,999999);
                $_SESSION['admin_otp'] = $otp;
                $_SESSION['admin_otp_expires'] = time() + 300; // 5 minutes

                // * step 3 --> Send OTP via email (can replace with a proper mailer if needed)
                // $to = $userData['email'];
                // $subject = "FurniScape Admin OTP verification";
                // $message = "Your OTP is: $otp. It will expires in 5 minutes.";
                // $headers = "From: no-reply@furniscape.com";

                // mail($to, $subject, $message, $headers);

                // * step 3 --> OTP to a log file (for development/testing)
                $logPath = __DIR__ . '/otp-log.txt';
                file_put_contents($logPath, "OTP for {$userData['email']}: $otp\n", FILE_APPEND);


                // * step 4 --> Redirect to OTP Verification
                header("Location: /FurniScape/app/views/admin/verify-2fa.php");
                exit;
            } else {
                // Set error message if login fails
                $_SESSION['error'] = "Invalid admin email or password.";
                header("Location: /FurniScape/app/views/admin/login.php");
                exit;
            }
        }
    }

    // * step 5 --> Method for verification
    public function verifyOTP() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $enteredOtp = $_POST['otp'];

            if (
                isset($_SESSION['admin_otp'], $_SESSION['admin_otp_expires'], $_SESSION['pending_admin']) && time() <= $_SESSION['admin_otp_expires']
            ) {
                if ($enteredOtp == $_SESSION['admin_otp']) {
                    //  Correct OTP
                    $_SESSION['user'] = $_SESSION['pending_admin'];

                    unset($_SESSION['admin_otp'], $_SESSION['admin_otp_expires'], $_SESSION['pending_admin']);

                    $_SESSION['success'] = "Login Successful.";
                    header("Location: /FurniScape/app/views/admin/adminDashboard.php");
                    exit;
                }
                else {
                    $_SESSION['error'] = "Incorrect OTP.";
                }
            }else {
                $_SESSION['error'] = "OTP expires or session invalid.";
            }

            header("Location: /FurniScape/app/views/admin/verify-2fa.php");
            exit;
        }
    }

    
    // DELETE
    public function delete() {
        if (isset($_GET['delete_id'])) {
            $this->user->id = $_GET['delete_id'];

            $id = $_GET['delete_id'];
            $this->user->id = $id;

            // Get user data for role checking
            $userToDelete = $this->user->findById($id);

            //  Check if user has orders
            $orders = $this->order->getByUserId($id);


            if (!empty($orders)) {
            $_SESSION['error'] = "Cannot delete user who has existing orders.";
            }
            // Prevent deleting admins
            elseif ($userToDelete && $userToDelete['role'] !== 'admin'){
                if ($this->user->delete()){
                    $_SESSION['success'] = "User deleted successfully.";
                }else{
                    $_SESSION['error'] = "User deletion failed.";
                }
            }else{
                $_SESSION['error'] = "Admins cannot be deleted.";
            }

            header("Location: /FurniScape/app/views/admin/userManagement.php");
            exit;
        }
    }

    //Fetch users for the view
    public function fetchUsers(){
        return $this->user->getAll(); //fetch all users
    }


// ----------------Login without OTP Verification-----------------------//
    
    //     public function login() {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $email = $_POST['email'];
    //         $password = $_POST['password'];

    //         // Fetch user data from the database
    //         $userData = $this->user->findByEmail($email);

    //         if ($userData && $this->user->verifyPassword($password, $userData['password']) && $userData['role'] === 'admin') {


    //             // adding 2-factor authentication *
    //             // * step-1 --> store user temporarily until OTP verification
    //             $_SESSION['user'] = [
    //                 'id' => $userData['id'],
    //                 'email' => $userData['email'],
    //                 'role' => $userData['role'],
    //                 'first_name' => $userData['first_name']
    //             ];

    //             // Redirect to admin dashboard
    //             header("Location: /FurniScape/app/views/admin/adminDashboard.php");
    //             exit;
    //         } else {
    //             // Set error message if login fails
    //             $_SESSION['error'] = "Invalid admin email or password.";
    //             header("Location: /FurniScape/app/views/admin/login.php");
    //             exit;
    //         }
    //     }
    // }


    
//     public function handleOrderUpdate() {
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         $orderId = $_POST['order_id'];
//         $status = $_POST['status'];
//         $delivery_date = $_POST['delivery_date'];

//         $result = $this->updateOrder($orderId, $status, $delivery_date);

//         if ($result) {
//             $_SESSION['success'] = "Order status updated successfully.";
//         } else {
//             $_SESSION['error'] = "Failed to update order status.";
//         }

//         // Redirect after update to avoid form resubmission
//         header("Location: /FurniScape/app/views/admin/orderManagement.php");
//         exit;
//         }
//     }

//     public function getOrderItems($orderId) {
//         return $this->order->getOrderItems($orderId);
// }

}


?>
