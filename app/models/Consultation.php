<?php

class Consultation{
    private $conn;
    private $table = 'consultations';

    public $id;
    public $user_id;   // foreign key
    public $preferred_date;
    public $preferred_time;
    public $mode;
    public $topic;
    public $description;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new consultation
    public function create() {
        $query = "INSERT INTO " . $this->table . " (user_id, preferred_date, preferred_time, mode, topic, description, status) VALUES (:user_id, :preferred_date, :preferred_time, :mode, :topic, :description, 'pending')";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':preferred_date', $this->preferred_date);
        $stmt->bindParam(':preferred_time', $this->preferred_time);
        $stmt->bindParam(':mode', $this->mode);
        $stmt->bindParam(':topic', $this->topic);
        $stmt->bindParam(':description', $this->description);

        return $stmt->execute();
    }

    
    // Get all Consultation requests
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     // Update status of a consultation
    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

     // Get all consultaion requests by specific user
    public function getByUserId($userId) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        // Delete a consultation (if needed)
    public function deleteConsultaionRequest($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id AND status = 'Pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function canUserDeleteConsultation($id, $userId) {
        $query = "SELECT * FROM " . $this->table . " 
                WHERE id = :id AND user_id = :user_id AND status = 'Pending'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Find consultations by user ID (for user dashboard)
    // public function findByUserId($user_id) {
    //     $query = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id ORDER BY created_at DESC";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(':user_id', $user_id);
    //     $stmt->execute();

    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
    



}

?>