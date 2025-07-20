<?php
require_once '../models/Cart.php';
class CartController
{
    protected $cart;
    protected $userId;

    public function __construct()
    {
        $this->cart = new Cart();
        $this->userId = $_SESSION['user'];
    }

    public function addToCart()
    {
        try {
            $itemId = $_POST['item_id'];
            $quantity = $_POST['quantity'];

            $existingItem = $this->cart->getItem($this->userId, $itemId);

            if ($existingItem) {
                $newQuantity = $existingItem['quantity'] + $quantity;
                $this->cart->updateQuantity($this->userId, $itemId, $newQuantity);
            } else {
                $this->cart->addItem($this->userId, $itemId, $quantity);
            }
            header("Location: /cart");
            exit;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function viewCart()
    {
        try {
            $items = $this->cart->getCart($this->userId);

            include __DIR__ . '/../views/cart/view.php';  
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateCart()
    {
        try {
            $itemId = $_POST['item_id'];
            $quantity = $_POST['quantity'];

            $this->cart->updateQuantity($this->userId, $itemId, $quantity);
            header("Location: /cart");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function removeFromCart()
    {
        try {
            $itemId = $_POST['item_id'];
            $this->cart->removeItem($this->userId, $itemId);
            header("Location: /cart");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
