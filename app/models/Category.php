
<?php

class Category{
    private $conn;
    public $table = 'categories';
    
    public $category_id;
    public $category_name;
    public $category_desc;
    public $category_image;

    public function __construct($db) {
        $this->conn = $db;

    }

    // Create a new Category
    public function create(){
        //SQL query to create a category
        $query = "INSERT INTO " . $this->table . " (category_name, category_desc, category_image) VALUES (:category_name, :category_desc, :category_image)";
        //Prepare the query
        $stmt = $this->conn->prepare($query);

        //Bind Parameters
        $stmt->bindParam(':category_name', $this->category_name);
        $stmt->bindParam(':category_desc', $this->category_desc);
        $stmt->bindParam(':category_image', $this->category_image);

        //Execute the query
        if ($stmt->execute()){
            return true;
        }
        return false;

    }

    // Get all  categories
    public function getAll(){
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    // // Get a single category by ID
    // public function getOne(){
    //     $query = "SELECT * FROM " . $this->table . " WHERE category_id = :category_id LIMIT 1";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(':category_id', $this->category_id);
    //     $stmt->execute();

    //     return $stmt->fetch(PDO::FETCH_ASSOC);

    // }

    public function getById($category_id){
        $query = "SELECT * FROM " . $this->table . " WHERE category_id = :category_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        // $stmt->bindParam(':category_id', $category_id);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);   
    }

    // Update Category
    public function update(){
        $query = "UPDATE " . $this->table . 
        " SET category_name = :category_name, 
        category_desc = :category_desc, 
        category_image = :category_image 
        WHERE category_id = :category_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':category_name', $this->category_name);
        $stmt->bindParam(':category_desc', $this->category_desc);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':category_image', $this->category_image);

        if ($stmt->execute()){
            return true;
        }
        return false;

    }

    // Delete Category
    public function delete(){
        $query = "DELETE FROM " . $this->table . " WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $this->category_id);
        
        if ($stmt->execute()){
            return true;
        }
        return false;

    }

    
}