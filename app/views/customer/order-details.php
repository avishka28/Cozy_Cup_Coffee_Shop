<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <a href="<?php echo SITE_URL; ?>/public/index.php?page=account" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Back to Account
            </a>
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-box me-3"></i>Order Details
            </h1>
            <p class="text-muted">Order #<?php echo $order['id']; ?></p>
        </div>
    </div>
    
    <div class="row g-4 mb-5">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Order ID</small>
                        <p class="mb-0"><strong>#<?php echo $order['id']; ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Order Type</small>
                        <p class="mb-0"><span class="badge bg-info"><?php echo SecurityHelper::escapeOutput($order['order_type']); ?></span></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <p class="mb-0">
                            <span class="badge bg-<?php echo $order['status'] === 'Completed' ? 'success' : ($order['status'] === 'Pending' ? 'warning' : 'danger'); ?>">
                                <?php echo SecurityHelper::escapeOutput($order['status']); ?>
                            </span>
                        </p>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted">Order Date</small>
                        <p class="mb-0"><strong><?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></strong></p>
                    </div>
                    
                    <?php if ($order['order_type'] === 'Delivery'): ?>
                        <hr>
                        <div>
                            <small class="text-muted">Delivery Address</small>
                            <p class="mb-0"><strong><?php echo SecurityHelper::escapeOutput($order['delivery_address']); ?></strong></p>
                        </div>
                    <?php elseif ($order['order_type'] === 'Dine-in'): ?>
                        <hr>
                        <div>
                            <small class="text-muted">Table Number</small>
                            <p class="mb-0"><strong>Table <?php echo $order['table_id']; ?></strong></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
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
                                        <td>Rs.<?php echo number_format($item['item_price'], 2); ?></td>
                                        <td><strong>Rs.<?php echo number_format($item['item_price'] * $item['quantity'], 2); ?></strong></td>
                                        <td><small><?php echo SecurityHelper::escapeOutput($item['special_requests']); ?></small></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Order Total</h5>
                        <h3 class="text-primary mb-0">Rs.<?php echo number_format($order['total_price'], 2); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
