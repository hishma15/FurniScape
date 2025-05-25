<!-- NOT USING THIS AS THE CART IS SESSION BASED NOT DATABASE BASED -->

<!--<?php

class Cart {
    private $conn;
    public $table = 'carts';

    public $cart_id;
    public $user_id; // foreign key
    public $product_id;
    public $quantity;
    public $cearted_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get cart ID for a user; create cart if not exists
    public function getCartIdByUser($userId) {
        $query = "SELECT cart_id FROM " . $this->table . " WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cart) {
            $insertQuery = "INSERT INTO " . $this->table . " (user_id) VALUES (:user_id)";
            $insertStmt = $this->conn->prepare($insertQuery);
            $insertStmt->bindParam(':user_id', $userId);
            if ($insertStmt->execute()) {
                return $this->conn->lastInsertId();
            }
            return false; // Or throw exception on failure
        }

        return $cart['cart_id'];
    }


    public function addToCart($userId, $productId, $quantity = 1) {
        $cartId = $this->getCartIdByUser($userId);

        $stmt = $this->conn->prepare("SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ?");
        $stmt->execute([$cartId, $productId]);

        if ($stmt->rowCount() > 0) {
            $stmt = $this->conn->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE cart_id = ? AND product_id = ?");
            $stmt->execute([$quantity, $cartId, $productId]);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$cartId, $productId, $quantity]);
        }
    }

    public function getCartItems($userId) {
        $cartId = $this->getCartIdByUser($userId);

        $stmt = $this->conn->prepare("
            SELECT ci.*, p.product_name, p.price, p.productImage 
            FROM cart_items ci 
            JOIN products p ON ci.product_id = p.product_id 
            WHERE ci.cart_id = ?");
        $stmt->execute([$cartId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function clearCart($userId) {
        $cartId = $this->getCartIdByUser($userId);
        $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE cart_id = ?");
        $stmt->execute([$cartId]);
    }
} 



?> -->