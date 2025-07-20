<?php
require_once __DIR__ . '/../config/Database.php';
class Menu
{

    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function createItem($name, $description, $price, $image)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO menu (name, description, price, image) VALUES (:name, :description, :price, :image)");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error inserting menu item: " . $e->getMessage());
        }
    }

    public function getAllItems()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM menu");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Error retrieving menu items: " . $e->getMessage());
        }
    }

    public function getItemById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM menu WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Error retrieving menu item: " . $e->getMessage());
        }
    }

    public function updateItem($id, $name, $description, $price, $image)
    {
        try {
            $stmt = $this->db->prepare("UPDATE menu SET name = :name, description = :description, price = :price, image = :image WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error updating menu item: " . $e->getMessage());
        }
    }

    public function deleteItem($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM menu WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error deleting menu item: " . $e->getMessage());
        }
    }
}
