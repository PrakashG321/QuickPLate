<?php
require_once __DIR__ . '/../config/Database.php';
class Cart
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function addItem($userId, $itemId, $quantity)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO cart (user_id, item_id, quantity) VALUES (:userId, :itemId, :quantity)");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error adding item to cart: " . $e->getMessage());
        }
    }

    public function getItem($userId, $itemId)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM cart WHERE user_id = :userId AND item_id = :itemId");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(); 
        } catch (PDOException $e) {
            throw new Exception("Error checking if item exists in cart: " . $e->getMessage());
        }
    }


    public function getCart($userId)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT 
                cart.item_id, 
                cart.quantity, 
                menu.name, 
                menu.description, 
                menu.price, 
                menu.image 
            FROM cart
            JOIN menu ON cart.item_id = menu.id
            WHERE cart.user_id = :userId
        ");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(); // Return all cart items with full details
        } catch (PDOException $e) {
            throw new Exception("Error retrieving cart items: " . $e->getMessage());
        }
    }


    public function updateQuantity($userId, $itemId, $quantity)
    {
        try {
            $stmt = $this->db->prepare("UPDATE cart SET quantity = :quantity WHERE user_id = :userId AND item_id = :itemId");
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error updating cart item: " . $e->getMessage());
        }
    }

    public function removeItem($userId, $itemId)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM cart WHERE user_id = :userId AND item_id = :itemId");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error removing item from cart: " . $e->getMessage());
        }
    }

    public function clearCart($userId)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM cart WHERE user_id = :userId");
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error clearing cart: " . $e->getMessage());
        }
    }
}
