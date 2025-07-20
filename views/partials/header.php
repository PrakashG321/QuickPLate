<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickPlate - Food Ordering App</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <h1><a href="/" style="color: var(--white); text-decoration: none;">QuickPlate</a></h1>
            </div>
            <nav>
                <div class="nav-menu">
                    <a href="/">Home</a>
                    <?php if (!empty($_SESSION['user'])): ?>
                        <a href="/menu">Menu</a>
                        <a href="/cart">Cart</a>
                        <a href="/orders">My Orders</a>
                        <a href="/profile">Profile</a>
                        <a href="/logout">Logout</a>
                    <?php else: ?>
                        <a href="/register">Register</a>
                        <a href="/login">Login</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>
