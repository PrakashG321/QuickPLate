<?php
class Order
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createOrder($userId, $totalPrice, $shippingAddress, $paymentMethod)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO orders 
                                        (user_id, total, status, shipping_address, payment_method) 
                                        VALUES 
                                        (:userId, :totalPrice, 'Pending', :shippingAddress, :paymentMethod)");

            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':totalPrice', $totalPrice, PDO::PARAM_STR);
            $stmt->bindParam(':shippingAddress', $shippingAddress, PDO::PARAM_STR);
            $stmt->bindParam(':paymentMethod', $paymentMethod, PDO::PARAM_STR);

            $stmt->execute();
            return $this->db->lastInsertId(); // Return the order ID
        } catch (PDOException $e) {
            throw new Exception("Error creating order: " . $e->getMessage());
        }
    }

    public function addOrderItem($orderId, $itemId, $quantity, $price)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO order_items (order_id, menu_item_id, quantity, price) VALUES (:orderId, :itemId, :quantity, :price)");
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error adding item to order: " . $e->getMessage());
        }
    }

    public function getUserOrders($userId)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT 
                orders.id AS order_id, 
                orders.status, 
                orders.total, 
                orders.created_at, 
                order_items.quantity, 
                order_items.price, 
                menu.name AS item_name,
                menu.image AS item_image
            FROM orders
            JOIN order_items ON orders.id = order_items.order_id
            JOIN menu ON order_items.menu_item_id = menu.id
            WHERE orders.user_id = :userId
        ");

            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Error retrieving orders: " . $e->getMessage());
        }
    }



    public function getOrderDetails($orderId)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM order_items WHERE order_id = :orderId");
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Error retrieving order details: " . $e->getMessage());
        }
    }

    public function updateOrderStatus($orderId, $status)
    {
        try {
            $stmt = $this->db->prepare("UPDATE orders SET status = :status WHERE id = :orderId");
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error updating order status: " . $e->getMessage());
        }
    }
}
