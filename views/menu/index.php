<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - QuickPlate</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <main>
        <div class="container">
            <div class="menu-header">
                <h2>Our Delicious Menu</h2>
                <?php if (isset($_SESSION['user']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="/menu/create" class="btn btn-success">Add Item to Menu</a>
                <?php endif; ?>
            </div>

            <div class="menu-grid">
                <?php foreach ($items as $item): ?>
                    <div class="menu-card">
                        <img src="/uploads/<?= htmlspecialchars($item['image']) ?>"
                            alt="<?= htmlspecialchars($item['name']) ?>" class="menu-image">
                        <div class="menu-content">
                            <h3><?= htmlspecialchars($item['name']) ?></h3>
                            <p><?= htmlspecialchars($item['description']) ?></p>
                            <div class="menu-price">$<?= htmlspecialchars($item['price']) ?></div>

                            <div class="menu-actions">
                                <?php if (isset($_SESSION['user']) && $_SESSION['role'] === 'customer'): ?>
                                    <form method="post" action="/cart/add" class="d-flex align-center gap-1">
                                        <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['id']) ?>">
                                        <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['user']) && $_SESSION['role'] === 'admin'): ?>
                                    <a href="/menu/edit/<?= $item['id'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="/menu/delete/<?= $item['id'] ?>" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>