<?php

class Product{
    private $conn;
    public $table = 'products';

    public $product_id;
    public $product_name;
    public $no_of_stock;
    public $price;
    public $type;
    public $productImage;
    public $description;
    public $category_id;  // foreign key
    public $is_featured;


    public function __construct($db){
        $this->conn = $db;
    }

    // Create a new Product
    public function create(){
        //SQL query to create a product
        $query = "INSERT INTO " . $this->table . " (product_name, no_of_stock, price, type, productImage, description, category_id, is_featured) VALUES (:product_name, :no_of_stock, :price, :type, :productImage, :description, :category_id, :is_featured)";

        //Prepare the query
        $stmt = $this->conn->prepare($query);

        //Bind Parameters
        $stmt->bindParam(':product_name', $this->product_name);
        $stmt->bindParam(':no_of_stock', $this->no_of_stock);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':productImage', $this->productImage);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':is_featured', $this->is_featured);

        //Execute the query
        if ($stmt->execute()){
            return true;
        }
        return false;

    }

    // Get all  products
    public function getAll(){
        // SQL Query to get all products with category name.
        $query = "SELECT products.*, categories.category_name 
          FROM " . $this->table . 
          " JOIN categories ON products.category_id = categories.category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    //  // Get a single product by ID
    // public function getOne(){
    //     $query = "SELECT * FROM " . $this->table . " WHERE product_id = :product_id LIMIT 1";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(':product_id', $this->product_id);
    //     $stmt->execute();

    //     return $stmt->fetch(PDO::FETCH_ASSOC);

    // }

    // Get a single product by ID
    public function getProductById($productId){
        $query = "SELECT * FROM " . $this->table . " WHERE product_id = :product_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    // Get products by category id
    public function getByCategory($categoryId){
        $query = "SELECT * FROM products WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);    
    }

    // Update product
    public function update(){
        $query = "UPDATE " . $this->table . 
        " SET product_name = :product_name, 
        no_of_stock = :no_of_stock,
        price = :price,
        type = :type,
        productImage = :productImage,
        description = :description,
        category_id = :category_id, 
        is_featured = :is_featured
        WHERE product_id = :product_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':product_name', $this->product_name);
        $stmt->bindParam(':no_of_stock', $this->no_of_stock);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':productImage', $this->productImage);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':is_featured', $this->is_featured);

        if ($stmt->execute()){
            return true;
        }
        return false;

    }  

    // Delete Product
    public function delete(){
        $query = "DELETE FROM " .$this->table . " WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $this->product_id);
        
        if ($stmt->execute()){
            return true;
        }
        return false;

    }

    public function getFeaturedProducts() {
        $query = "SELECT * FROM products WHERE is_featured = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // To search Functionality
    // public function search($term) {
    // $term = "%" . $term . "%";
    // $query = "SELECT * FROM products 
    //           WHERE product_name LIKE :term 
    //           OR description LIKE :term";

    // $stmt = $this->conn->prepare($query);
    // $stmt->bindParam(':term', $term);
    // $stmt->execute();

    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }


}

?>
