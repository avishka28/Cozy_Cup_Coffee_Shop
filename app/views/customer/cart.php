<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 fw-bold mb-2">
                <i class="fas fa-shopping-cart me-3"></i>Shopping Cart
            </h1>
            <p class="text-muted">Review your items before checkout</p>
        </div>
    </div>
    
    <?php if (empty($items)): ?>
        <div class="row">
            <div class="col-12">
                <div class="empty-state card border-0 shadow-sm">
                    <div class="card-body py-5">
                        <i class="fas fa-shopping-cart"></i>
                        <h4 class="mt-3">Your cart is empty</h4>
                        <p class="text-muted mb-4">Start adding items to your cart</p>
                        <a href="<?php echo SITE_URL; ?>/public/index.php?page=menu" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Cart Items</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo SecurityHelper::escapeOutput($item['name']); ?></strong>
                                                <?php if ($item['special_requests']): ?>
                                                    <br><small class="text-muted"><i class="fas fa-note-sticky me-1"></i><?php echo SecurityHelper::escapeOutput($item['special_requests']); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>Rs.<?php echo number_format($item['price'], 2); ?></td>
                                            <td>
                                                <form method="POST" action="<?php echo SITE_URL; ?>/public/index.php?action=update-quantity" class="d-flex gap-2">
                                                    <?php echo SecurityHelper::getCSRFTokenField(); ?>
                                                    <input type="hidden" name="menu_item_id" value="<?php echo $item['id']; ?>">
                                                    <input type="number" class="form-control form-control-sm" style="width: 70px;" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="10">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-sync"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td><strong>Rs.<?php echo number_format($item['subtotal'], 2); ?></strong></td>
                                            <td>
                                                <a href="<?php echo SITE_URL; ?>/public/index.php?action=remove-from-cart&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>Rs.<?php echo number_format($total, 2); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax (0%):</span>
                            <strong>Rs.0.00</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fs-5">Total:</span>
                            <strong class="fs-5 text-primary">Rs.<?php echo number_format($total, 2); ?></strong>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/public/index.php?page=checkout" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                        </a>
                        <a href="<?php echo SITE_URL; ?>/public/index.php?page=menu" class="btn btn-outline-primary w-100">
                            <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
