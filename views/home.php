<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickPlate - Food Ordering App</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../views/partials/header.php'; ?>
    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h2>Welcome to QuickPlate</h2>
                    <p>
                        QuickPlate allows you to browse the menu, place orders, and track your food deliveries.
                        Join us and enjoy your favorite meals delivered right to your door.
                    </p>
                    <div class="hero-buttons">
                        <?php if (empty($_SESSION['user'])): ?>
                            <a href="/register" class="btn btn-primary">Get Started</a>
                            <a href="/login" class="btn btn-secondary">Sign In</a>
                        <?php else: ?>
                            <a href="/menu" class="btn btn-primary">Go to Menu</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="container">
                <div class="text-center">
                    <h3>Why Choose QuickPlate?</h3>
                </div>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">🍔</div>
                        <h4>Browse Menu</h4>
                        <p>Explore a variety of delicious meals and find your favorites from our extensive menu.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🔒</div>
                        <h4>Secure Ordering</h4>
                        <p>Your orders are safe with encrypted data and secure payment options for peace of mind.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🚚</div>
                        <h4>Track Your Order</h4>
                        <p>Follow your order in real-time and know exactly when your delicious meal will arrive.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/../views/partials/footer.php'; ?>
</body>

</html>