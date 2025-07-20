<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Cart.php';

class CheckoutController
{
    protected $orderModel;
    protected $cartModel;
    protected $userId;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->cartModel = new Cart();
        $this->userId = $_SESSION['user']; 
    }

    // Process the checkout
    public function checkout()
    {
        try {
            $items = $this->cartModel->getCart($this->userId);
            if (empty($items)) {
                throw new Exception("Your cart is empty. Please add items to your cart before checking out.");
            }

            $totalPrice = 0;
            foreach ($items as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }

            include __DIR__ . '/../views/checkout/checkout.php';  

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function submitOrder()
    {
        try {

            $address = $_POST['address'];
            $paymentMethod = $_POST['payment_method'];

            $items = $this->cartModel->getCart($this->userId);
            if (empty($items)) {
                throw new Exception("Your cart is empty. Please add items to your cart before checking out.");
            }

            $totalPrice = 0;
            foreach ($items as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }

            $orderId = $this->orderModel->createOrder($this->userId, $totalPrice, $address, $paymentMethod);

            foreach ($items as $item) {
                $this->orderModel->addOrderItem($orderId, $item['item_id'], $item['quantity'], $item['price']);
            }

            $this->cartModel->clearCart($this->userId);

            header("Location: /orders"); 
            exit;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
