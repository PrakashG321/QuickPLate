<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders - QuickPlate</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <main>
        <div class="container">
            <h2>Your Orders</h2>
            <div id="ajax-orders" class="orders-container"></div>
        </div>
    </main>

    <?php include __DIR__ . '/../partials/footer.php'; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('/orders/json')
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(orders => {
                    const container = document.getElementById('ajax-orders');
                    if (orders.length === 0) {
                        container.innerHTML = `
                            <div class="text-center" style="padding: 4rem 0;">
                                <div style="font-size: 4rem; margin-bottom: 1rem;">📦</div>
                                <h3>No orders yet</h3>
                                <p>You haven't placed any orders yet. Start by browsing our menu!</p>
                                <a href="/menu" class="btn btn-primary mt-2">Browse Menu</a>
                            </div>
                        `;
                        return;
                    }

                    let html = '';
                    let currentOrderId = null;

                    orders.forEach(order => {
                        if (currentOrderId !== order.order_id) {
                            if (currentOrderId !== null) {
                                html += '</ul></div></div>';
                            }

                            html += `
                                <div class="order-card">
                                    <div class="order-header">
                                        <div>
                                            <h3>Order #${order.order_id}</h3>
                                            <p style="color: var(--gray-medium);">${order.created_at}</p>
                                        </div>
                                        <div>
                                            <span class="order-status status-${order.status.toLowerCase()}">
                                                ${order.status}
                                            </span>
                                            <p style="font-size: 1.25rem; font-weight: bold; color: var(--primary-color);">
                                                $${parseFloat(order.total).toFixed(2)}
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <h4>Items:</h4>
                                        <ul class="order-items">
                            `;
                            currentOrderId = order.order_id;
                        }

                        html += `
                            <li class="order-item">
                                <div class="item-details">
                                    <img src="/uploads/${order.item_image}" 
                                         alt="${order.item_name}" 
                                         class="item-image">
                                    <span>${order.item_name} (x${order.quantity})</span>
                                </div>
                                <span>$${(order.price * order.quantity).toFixed(2)}</span>
                            </li>
                        `;
                    });

                    html += '</ul></div></div>'; // Close final order
                    container.innerHTML = html;
                })
                .catch(err => {
                    console.error('Failed to fetch orders:', err);
                    document.getElementById('ajax-orders').innerHTML = '<p>Error loading orders.</p>';
                });
        });
    </script>
</body>

</html>
