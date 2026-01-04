<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-5">
    <div class="row mb-4">
        <div class="col-12">
            <a href="<?php echo SITE_URL; ?>/public/index.php?page=customer-management" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Back to Customers
            </a>
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-user-circle me-3"></i>Customer Details
            </h1>
            <p class="text-muted">View customer information and order history</p>
        </div>
    </div>
    
    <div class="row g-4 mb-5">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Customer ID</small>
                        <p class="mb-0"><strong>#<?php echo $customer['id']; ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Full Name</small>
                        <p class="mb-0"><strong><?php echo SecurityHelper::escapeOutput($customer['full_name']); ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Email Address</small>
                        <p class="mb-0"><a href="mailto:<?php echo SecurityHelper::escapeOutput($customer['email']); ?>"><?php echo SecurityHelper::escapeOutput($customer['email']); ?></a></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Phone Number</small>
                        <p class="mb-0"><a href="tel:<?php echo SecurityHelper::escapeOutput($customer['phone']); ?>"><?php echo SecurityHelper::escapeOutput($customer['phone']); ?></a></p>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted">Member Since</small>
                        <p class="mb-0"><strong><?php echo date('M d, Y', strtotime($customer['created_at'])); ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-box me-2"></i>Order History</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($orders)): ?>
                        <div class="empty-state p-5">
                            <i class="fas fa-inbox"></i>
                            <h6 class="mt-3">No Orders</h6>
                            <p class="text-muted small">This customer hasn't placed any orders yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><strong>#<?php echo $order['id']; ?></strong></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php echo SecurityHelper::escapeOutput($order['order_type']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                            <td><strong>Rs.<?php echo number_format($order['total_price'], 2); ?></strong></td>
                                            <td>
                                                <span class="badge bg-<?php echo $order['status'] === 'Completed' ? 'success' : ($order['status'] === 'Pending' ? 'warning' : 'danger'); ?>">
                                                    <?php echo SecurityHelper::escapeOutput($order['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?php echo SITE_URL; ?>/public/index.php?page=admin-order-details&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
