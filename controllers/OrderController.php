<?php
// OrderController.php

require_once '../models/Cart.php';
require_once '../models/Order.php';
class OrderController
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

    public function viewOrders($userId)
    {
        include __DIR__ . '/../views/orders/orders.php'; 
    }

    public function getOrdersJson($userId)
    {
        $orders = $this->orderModel->getUserOrders($userId);
        header('Content-Type: application/json');
        echo json_encode($orders);
    }
}
