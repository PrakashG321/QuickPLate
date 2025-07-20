<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - QuickPlate</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <main>
        <div class="container">
            <h2>Checkout</h2>

            <?php if (!is_array($items) || empty($items)): ?>
                <div class="text-center" style="padding: 4rem 0;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">🛒</div>
                    <h3>Your cart is empty</h3>
                    <p>Please add items to your cart before proceeding with checkout.</p>
                    <a href="/menu" class="btn btn-primary mt-2">Browse Menu</a>
                </div>
            <?php else: ?>
                <div class="checkout-container">
                    <div class="checkout-section">
                        <h3>Order Summary</h3>
                        <div class="cart-items">
                            <?php
                            $grandTotal = 0;
                            foreach ($items as $item):
                                $total = $item['price'] * $item['quantity'];
                                $grandTotal += $total;
                            ?>
                                <div class="cart-item">
                                    <div class="cart-item-info">
                                        <h4><?= htmlspecialchars($item['name']) ?></h4>
                                        <p>Price: $<?= htmlspecialchars($item['price']) ?></p>
                                        <p>Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
                                        <p><strong>Total: $<?= htmlspecialchars($total) ?></strong></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="cart-total">
                            Grand Total: $<?= htmlspecialchars($grandTotal) ?>
                        </div>
                    </div>

                    <div class="checkout-section">
                        <h3>Shipping & Payment</h3>
                        <form method="post" action="/checkout/submit">
                            <div class="form-group">
                                <label for="address">Shipping Address</label>
                                <textarea name="address" id="address" class="form-control" rows="4" required
                                    placeholder="Enter your complete delivery address"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="payment_method">Payment Method</label>
                                <select name="payment_method" id="payment_method" class="form-control" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="cod">Cash on Delivery</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%;">
                                Place Order - $<?= htmlspecialchars($grandTotal) ?>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>