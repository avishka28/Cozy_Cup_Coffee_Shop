<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="qr-cart-container">
    <h1>Table <?php echo SecurityHelper::escapeOutput($table_number); ?> - Order</h1>
    
    <?php if (empty($items)): ?>
        <p class="empty-cart">Your cart is empty. <a href="<?php echo SITE_URL; ?>/public/index.php?page=qr-menu&table=<?php echo urlencode($table_number); ?>">Continue shopping</a></p>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Special Requests</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo SecurityHelper::escapeOutput($item['name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
                        <td><?php echo SecurityHelper::escapeOutput($item['special_requests']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="cart-summary">
            <h3>Order Summary</h3>
            <p class="total">Total: $<?php echo number_format($total, 2); ?></p>
            
            <form method="POST" action="<?php echo SITE_URL; ?>/public/index.php?action=qr-checkout">
                <?php echo SecurityHelper::getCSRFTokenField(); ?>
                <input type="hidden" name="table_number" value="<?php echo SecurityHelper::escapeOutput($table_number); ?>">
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
            
            <a href="<?php echo SITE_URL; ?>/public/index.php?page=qr-menu&table=<?php echo urlencode($table_number); ?>" class="btn btn-secondary">Continue Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
