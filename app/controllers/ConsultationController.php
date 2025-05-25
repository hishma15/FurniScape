<?php 

require_once 'C:\xampp\htdocs\FurniScape\config\database.php';
require_once 'C:\xampp\htdocs\FurniScape\app\models\Consultation.php';
require_once 'C:\xampp\htdocs\FurniScape\app\models\User.php';

class ConsultationController{

    private $db;
    private $consultation;

    public function __construct(){
        $database = new Database();
        $this->db = $database->connect();

        $this->consultation = new Consultation($this->db);
        $this->user = new User($this->db);
    }

    // Customer: Book Consultation
    public function book() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user'])) {
                $_SESSION['error'] = "You must be logged in to book a consultation.";
                header("Location: /FurniScape/app/views/customer/customerLogin.php");
                exit;
            }

            $this->consultation->user_id = $_SESSION['user']['id'];
            $this->consultation->preferred_date = $_POST['preferred_date'];
            $this->consultation->preferred_time = $_POST['preferred_time'];
            $this->consultation->mode = $_POST['mode'];
            $this->consultation->topic = $_POST['topic'];
            $this->consultation->description = $_POST['description'];

            if ($this->consultation->create()) {
                $_SESSION['success'] = "Consultation request submitted successfully.";
                header("Location: /FurniScape/app/views/customer/home.php");
                exit;
            } else {
                $_SESSION['error'] = "Failed to submit consultation.";
                header("Location: /FurniScape/app/views/customer/consultationForm.php");
                exit;
            }
        }
    }


    // Admin: View all consultations
    public function list() {
        return $this->consultation->getAll();
    }

    // Admin: Update consultation status
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['consultation_id'];
            $status = $_POST['status'];

            if ($this->consultation->updateStatus($id, $status)) {
                $_SESSION['success'] = "Consultation status updated.";
            } else {
                $_SESSION['error'] = "Failed to update status.";
            }

            header("Location: /FurniScape/app/views/admin/consultationManagement.php");
            exit;
        }
    }

    // (Optional) delete
    // public function delete() {
    //     if (isset($_GET['delete_id'])) {
    //         $id = $_GET['delete_id'];
    //         if ($this->consultation->delete($id)) {
    //             $_SESSION['success'] = "Consultation deleted.";
    //         } else {
    //             $_SESSION['error'] = "Failed to delete consultation.";
    //         }
    //         header("Location: /FurniScape/app/views/admin/consultationManagement.php");
    //         exit;
    //     }
    // }

    // Get user info to autofill the form
    public function getUserDetails() {

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
            header("Location: /FurniScape/app/views/customer/customerLogin.php");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        return $this->user->findById($userId);
    }    

    public function getConsultationByUserId($userId) {
    return $this->consultation->getByUserId($userId);
    }


    public function DeleteUserConsultationRequest($consultationId) {
        
        $userId = $_SESSION['user']['id'];

        // Check if user can delete this consultation
        if ($this->consultation->canUserDeleteConsultation($consultationId, $userId)) {
            $deleted = $this->consultation->deleteConsultaionRequest($consultationId);

            if ($deleted) {
                $_SESSION['success'] = "Consultation request deleted successfully.";
            } else {
                $_SESSION['error'] = "Failed to delete cnsultation request.";
            }
        } else {
            $_SESSION['error'] = "You can only delete pending consultation that belong to you.";
        }

        header("Location: /FurniScape/app/views/customer/viewOrder.php");
        exit;

    }

}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Controller instantiation
$controller = new ConsultationController();

// Route the request based on query parameters or form action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'bookConsultation') {
        $controller->book();
    } elseif ($action === 'updateConsultationStatus') {
        $controller->updateStatus();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $controller->DeleteUserConsultationRequest($_GET['delete_id']);
}



?>