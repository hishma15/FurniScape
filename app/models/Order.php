<?php

class Order{
    private $conn;
    public $table_orders = 'orders';
    public $table_order_items = 'order_items';

    public $order_id;
    public $user_id;
    public $total;
    public $home_no;
    public $street;
    public $city;
    public $status;
    public $created_at;
    public $delivery_date;

    
    public function __construct($db) {
        $this->conn = $db;
    }

    // Place a new Order
    public function place($user_id, $cartItems, $home_no, $street, $city, $delivery_date, $total) {

        try{
            $this->conn->beginTransaction();   // Ensures that either all queries succeed and data saved or something fails nd everything is rolled back.

            // Insert into orders table
            $query = "INSERT INTO " . $this->table_orders . " (user_id, total, home_no, street, city, status, created_at, delivery_date) VALUES (:user_id, :total, :home_no, :street, :city, 'Pending', NOW(), :delivery_date)";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':home_no', $home_no);
            $stmt->bindParam(':street', $street);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':delivery_date', $delivery_date);
                   
            if (!$stmt->execute()) {
                $this->conn->rollBack();
                return false;
            }

            // Get order ID
            $order_id = $this->conn->lastInsertId();

            // Insert order items
            $itemQuery = "INSERT INTO " . $this->table_order_items . " (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";

            $stmtItem = $this->conn->prepare($itemQuery);

            foreach ($cartItems as $item) {
                $stmtItem->bindParam(':order_id', $order_id);
                $stmtItem->bindParam(':product_id', $item['product_id']);
                $stmtItem->bindParam(':quantity', $item['quantity']);
                $stmtItem->bindParam(':price', $item['price']);

                if (!$stmtItem->execute()) {
                    $this->conn->rollBack();
                    return false;
                }
            }

            $this->conn->commit();
            return $order_id;

        } catch (Exception $e){
            $this->conn->rollBack();
            return false;
        }

    }

    // Get all orders by user
    public function getByUserId($userId) {
        $query = "SELECT * FROM " . $this->table_orders . " 
                  WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get items for a specific order
    public function getOrderItems($orderId) {
        $query = "SELECT oi.*, p.product_name, p.productImage 
                  FROM " . $this->table_order_items . " oi 
                  JOIN products p ON oi.product_id = p.product_id 
                  WHERE oi.order_id = :order_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all orders
    public function getAllOrders() {
        $query = "SELECT * FROM " . $this->table_orders;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update order status
    public function updateOrder($orderId, $newStatus, $delivery_date) {
        $query = "UPDATE " . $this->table_orders . " 
                  SET status = :status, delivery_date = :delivery_date WHERE order_id = :order_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $newStatus);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->bindParam(':delivery_date', $delivery_date);

        return $stmt->execute();
    }

    // Delete an order (if needed)
    public function deleteOrder($orderId) {
        $query = "DELETE FROM " . $this->table_orders . " WHERE order_id = :order_id AND status = 'Pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        return $stmt->execute();
    }

    public function canUserDeleteOrder($orderId, $userId) {
        $query = "SELECT * FROM " . $this->table_orders . " 
                WHERE order_id = :order_id AND user_id = :user_id AND status = 'Pending'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

}

?>