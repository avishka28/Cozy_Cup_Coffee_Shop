<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="qr-confirmation-container">
    <h1>Order Confirmed</h1>
    
    <div class="confirmation-message">
        <p class="success-message">Your order has been placed successfully!</p>
        <p class="table-info">Table <?php echo SecurityHelper::escapeOutput($table_number); ?></p>
    </div>
    
    <div class="order-details">
        <h2>Order Details</h2>
        
        <div class="detail-section">
            <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
            <p><strong>Status:</strong> <?php echo SecurityHelper::escapeOutput($order['status']); ?></p>
            <p><strong>Order Date:</strong> <?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></p>
        </div>
        
        <h3>Items Ordered</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Special Requests</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo SecurityHelper::escapeOutput($item['name']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['item_price'], 2); ?></td>
                        <td>$<?php echo number_format($item['item_price'] * $item['quantity'], 2); ?></td>
                        <td><?php echo SecurityHelper::escapeOutput($item['special_requests']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <p class="total-price">Total: $<?php echo number_format($order['total_price'], 2); ?></p>
    </div>
    
    <div class="confirmation-message">
        <p>Your order will be prepared shortly. Please wait at your table.</p>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
