<?php

class User{
    private $conn;
    public $table = 'users'; //Name of the table in database

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $address;
    public $role;
    private $password;

    public function __construct($db) {
        $this->conn = $db;

    }


    //set password securely
    public function setPassword($plainPassword){
        $this->password = password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    //Register a customer
    public function register(){

        //Check whtheer the email already exists
        $checkQuery = "SELECT id FROM " . $this->table . " WHERE email = :email";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(':email', $this->email);
        $checkStmt->execute();

        if ($checkStmt->fetch()) {
            // Email already exists
            return false;
        }

        //SQL query to register/ create User
        $query= "INSERT INTO " . $this->table . "(first_name, last_name, email, password, phone, address, role) VALUES (:first_name, :last_name, :email, :password, :phone, :address, 'customer')";
        //Prepare the query
        $stmt = $this->conn->prepare($query);
    
        //Bind parameters
        // $stmt=bindParam(':id',$this->id);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':password', $this->password);

        //Execute the query
        if ($stmt->execute()){
            return true;
        }
        return false;

    }

    //Get user by email (for login)
    public function findByEmail($email){
        $query= "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyPassword($plainPassword, $hashedPassword){
        return password_verify($plainPassword, $hashedPassword);
    }

    // Get all  users
    public function getAll(){
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    //Find user by id
    public function findById($id){
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

        // Delete User
    public function delete(){
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()){
            return true;
        }
        return false;

    }    

    public function updateProfile($id, $data) {
        
        // Check if new email is already used by someone else
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email AND id != :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->fetch()) {
            // Email already exists for another user
            return "email_exists";
        }

        // Proceed with update if email is not taken
        $query = "UPDATE " . $this->table . " 
                SET first_name = :first_name, last_name = :last_name, phone = :phone, address = :address, email = :email 
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()){
            return true;
        }
        return false;
    }

    

}

?>