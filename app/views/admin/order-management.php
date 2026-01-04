<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-box me-3"></i>Order Management
            </h1>
            <p class="text-muted">Manage and track customer orders</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Orders</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($orders)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                            <p class="text-muted">No orders found</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><strong>#<?php echo $order['id']; ?></strong></td>
                                            <td><?php echo SecurityHelper::escapeOutput($order['full_name']); ?></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php echo SecurityHelper::escapeOutput($order['order_type']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></td>
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
                                                <?php if ($order['status'] === 'Pending'): ?>
                                                    <a href="<?php echo SITE_URL; ?>/public/index.php?action=approve-order&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-success" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="showRejectForm(<?php echo $order['id']; ?>)" title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                <?php elseif ($order['status'] === 'Processing'): ?>
                                                    <a href="<?php echo SITE_URL; ?>/public/index.php?action=complete-order&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-success" title="Complete">
                                                        <i class="fas fa-check-double"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i>Reject Order</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo SITE_URL; ?>/public/index.php?action=reject-order">
                <?php echo SecurityHelper::getCSRFTokenField(); ?>
                <div class="modal-body">
                    <input type="hidden" id="reject-order-id" name="order_id">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason (optional)</label>
                        <textarea id="reason" class="form-control" name="reason" rows="3" placeholder="Enter reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectForm(orderId) {
    document.getElementById('reject-order-id').value = orderId;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
