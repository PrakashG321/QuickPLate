<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary controllers
require_once '../controllers/AuthController.php';
require_once '../controllers/ProfileController.php';
require_once '../controllers/MenuController.php';
require_once '../controllers/CartController.php';
require_once '../controllers/CheckoutController.php';
require_once '../controllers/OrderController.php';


$route = $_GET['route'] ?? null;



if (!$route) {
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    $path = $requestUri;
    if (strpos($path, '?') !== false) {
        $path = strstr($path, '?', true);
    }
    if ($scriptName !== '/' && strpos($path, $scriptName) === 0) {
        $path = substr($path, strlen($scriptName));
    }
    $path = trim($path, '/');
    $route = $path ?: 'home';
}

if (preg_match('#^menu/edit/(\d+)$#', $route, $matches)) {
    $id = $matches[1];
    (new MenuController())->edit($id);
} elseif (preg_match('#^menu/delete/(\d+)$#', $route, $matches)) {
    $id = $matches[1];
    (new MenuController())->delete($id);
} elseif (preg_match('#^menu/update/(\d+)$#', $route, $matches)) {
    $id = $matches[1];
    (new MenuController())->update($id);
} else {
    switch ($route) {
        case 'home':
            include __DIR__ . '/../views/home.php';
            break;

        case 'register':
            (new AuthController())->register();
            break;

        case 'login':
            // Handle user login
            (new AuthController())->login();
            break;

        case 'logout':
            // Handle user logout
            (new AuthController())->logout();
            break;

        case 'menu':
            if (isset($_SESSION['user'])) {
                (new MenuController())->index();
            } else {
                header("Location: /login");
                exit;
            }
            break;

        case 'menu/create':
            (new MenuController())->create();
            break;

        case 'menu/edit/1':
            (new MenuController())->edit($id);
            break;

        // case 'menu/edit'

        case 'cart':
            if (isset($_SESSION['user'])) {
                (new CartController())->viewCart();
            } else {
                header("Location: /login");
                exit;
            }
            break;

        case 'cart/add':
            (new CartController())->addToCart();
            break;

        case 'cart/update':
            (new CartController())->updateCart();
            break;

        case 'cart/remove':
            (new CartController())->removeFromCart();
            break;

        case 'checkout':
            (new CheckoutController)->checkout();
            break;

        case 'checkout/submit':
            (new CheckoutController())->submitOrder();
            break;

        case 'orders':
            if (isset($_SESSION['user'])) {
                (new OrderController())->viewOrders($_SESSION['user']);
            } else {
                header("Location: /login");
                exit;
            }
            break;
        case 'profile':
            if (isset($_SESSION['user'])) {
                (new ProfileController())->viewProfile();
            } else {
                header("Location: /login");
                exit;
            }
            break;

        case 'update-profile':
            if (isset($_SESSION['user'])) {
                (new ProfileController())->update();
            } else {
                header("Location: /login");
                exit;
            }
            break;

        case 'delete-profile':
            if (isset($_SESSION['user'])) {
                (new ProfileController())->delete();
            } else {
                header("Location: /login");
                exit;
            }
            break;
        case 'orders/json':
            if (isset($_SESSION['user'])) {
                (new OrderController())->getOrdersJson($_SESSION['user']);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Not logged in']);
            }
            break;

        default:
            // Page not found (404)
            http_response_code(404);
            echo "<h2>404 Not Found</h2>";
            break;
    }
}
