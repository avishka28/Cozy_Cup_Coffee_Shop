<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="qr-order-container">
    <h1>Table Order</h1>
    
    <?php if (isset($table_number)): ?>
        <div class="table-info">
            <p class="table-number">Table <?php echo SecurityHelper::escapeOutput($table_number); ?></p>
            <p>Welcome! Please select items from our menu below.</p>
        </div>
    <?php endif; ?>
    
    <div class="menu-grid">
        <?php if (empty($items)): ?>
            <p class="no-items">No items available.</p>
        <?php else: ?>
            <?php foreach ($items as $item): ?>
                <div class="menu-item">
                    <?php if ($item['image_path']): ?>
                        <img src="<?php echo SITE_URL; ?>/public/uploads/<?php echo SecurityHelper::escapeOutput($item['image_path']); ?>" 
                             alt="<?php echo SecurityHelper::escapeOutput($item['name']); ?>" 
                             class="item-image">
                    <?php else: ?>
                        <div class="item-image-placeholder">No Image</div>
                    <?php endif; ?>
                    
                    <div class="item-details">
                        <h3><?php echo SecurityHelper::escapeOutput($item['name']); ?></h3>
                        <p class="item-description"><?php echo SecurityHelper::escapeOutput($item['description']); ?></p>
                        <p class="item-price">$<?php echo number_format($item['price'], 2); ?></p>
                        
                        <form method="POST" action="<?php echo SITE_URL; ?>/public/index.php?action=qr-add-to-cart">
                            <?php echo SecurityHelper::getCSRFTokenField(); ?>
                            <input type="hidden" name="menu_item_id" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="table_number" value="<?php echo SecurityHelper::escapeOutput($table_number); ?>">
                            <input type="number" name="quantity" value="1" min="1" max="10" required>
                            <textarea name="special_requests" placeholder="Special requests (optional)" rows="2"></textarea>
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <div class="qr-actions">
        <a href="<?php echo SITE_URL; ?>/public/index.php?page=qr-cart&table=<?php echo urlencode($table_number); ?>" class="btn btn-primary">View Cart</a>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
