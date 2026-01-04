<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 fw-bold mb-2">
                <i class="fas fa-credit-card me-3"></i>Checkout
            </h1>
            <p class="text-muted">Complete your order</p>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-box me-2"></i>Order Details</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo SITE_URL; ?>/public/index.php?action=checkout">
                        <?php echo SecurityHelper::getCSRFTokenField(); ?>
                        
                        <div class="mb-4">
                            <label for="order_type" class="form-label fw-bold">Order Type *</label>
                            <select id="order_type" class="form-select form-select-lg" name="order_type" required onchange="updateOrderTypeFields()">
                                <option value="">-- Select Order Type --</option>
                                <option value="Takeaway"><i class="fas fa-bag-shopping me-2"></i>Takeaway</option>
                                <option value="Delivery"><i class="fas fa-truck me-2"></i>Delivery</option>
                                <option value="Dine-in"><i class="fas fa-utensils me-2"></i>Dine-in</option>
                            </select>
                        </div>
                        
                        <div id="delivery-section" class="mb-4" style="display: none;">
                            <label for="delivery_address" class="form-label fw-bold">Delivery Address *</label>
                            <textarea id="delivery_address" class="form-control" name="delivery_address" rows="3" placeholder="Enter your complete delivery address"></textarea>
                        </div>
                        
                        <div id="dine-in-section" class="mb-4" style="display: none;">
                            <label for="table_id" class="form-label fw-bold">Select Table *</label>
                            <select id="table_id" class="form-select form-select-lg" name="table_id">
                                <option value="">-- Select a Table --</option>
                                <?php foreach ($tables as $table): ?>
                                    <option value="<?php echo $table['id']; ?>">
                                        Table <?php echo $table['table_number']; ?> (Capacity: <?php echo $table['capacity']; ?> guests)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="fas fa-check me-2"></i>Place Order
                            </button>
                            <a href="<?php echo SITE_URL; ?>/public/index.php?page=cart" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; ?>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td><small><?php echo SecurityHelper::escapeOutput($item['name']); ?></small></td>
                                        <td><small><?php echo $item['quantity']; ?></small></td>
                                        <td><small>Rs.<?php echo number_format($item['price'], 2); ?></small></td>
                                        <td><small><strong>Rs.<?php echo number_format($item['subtotal'], 2); ?></strong></small></td>
                                    </tr>
                                    <?php $total += $item['subtotal']; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <strong>Rs.<?php echo number_format($total, 2); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fs-5">Total:</span>
                        <strong class="fs-5 text-primary">Rs.<?php echo number_format($total, 2); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateOrderTypeFields() {
    const orderType = document.getElementById('order_type').value;
    const deliverySection = document.getElementById('delivery-section');
    const dineInSection = document.getElementById('dine-in-section');
    
    deliverySection.style.display = orderType === 'Delivery' ? 'block' : 'none';
    dineInSection.style.display = orderType === 'Dine-in' ? 'block' : 'none';
    
    if (orderType === 'Delivery') {
        document.getElementById('delivery_address').required = true;
    } else {
        document.getElementById('delivery_address').required = false;
    }
    
    if (orderType === 'Dine-in') {
        document.getElementById('table_id').required = true;
    } else {
        document.getElementById('table_id').required = false;
    }
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
