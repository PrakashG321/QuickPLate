<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - QuickPlate</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <main>
        <div class="container">
            <h2>Your Cart</h2>

            <?php if (!is_array($items) || empty($items)): ?>
                <div class="text-center" style="padding: 4rem 0;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">🛒</div>
                    <h3>Your cart is empty</h3>
                    <p>Add some delicious items from our menu!</p>
                    <a href="/menu" class="btn btn-primary mt-2">Browse Menu</a>
                </div>
            <?php else: ?>
                <div class="cart-container">
                    <div class="cart-items">
                        <?php
                        $grandTotal = 0;
                        foreach ($items as $item):
                            $total = $item['price'] * $item['quantity'];
                            $grandTotal += $total;
                        ?>
                            <div class="cart-item">
                                <div class="cart-item-info">
                                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                                    <p>Price: $<?= htmlspecialchars($item['price']) ?></p>
                                    <p>Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
                                    <p><strong>Total: $<?= htmlspecialchars($total) ?></strong></p>
                                </div>

                                <div class="cart-item-actions">
                                    <form method="post" action="/cart/update" class="d-flex align-center gap-1">
                                        <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                                        <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>"
                                            min="1" class="quantity-input">
                                        <button type="submit" class="btn btn-warning">Update</button>
                                    </form>

                                    <form method="post" action="/cart/remove"
                                        onsubmit="return confirm('Are you sure you want to remove this item?');">
                                        <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="cart-summary">
                        <h3>Order Summary</h3>
                        <div class="cart-total">
                            Total: $<?= htmlspecialchars($grandTotal) ?>
                        </div>
                        <a href="/checkout" class="btn btn-primary" style="width: 100%;">Proceed to Checkout</a>
                        <a href="/menu" class="btn btn-secondary mt-2" style="width: 100%;">Continue Shopping</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>