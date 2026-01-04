<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-users me-3"></i>Customer Management
            </h1>
            <p class="text-muted">View and manage customer information</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Customers</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Member Since</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($customers)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                            <p class="text-muted">No customers found</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($customers as $customer): ?>
                                        <tr>
                                            <td><strong>#<?php echo $customer['id']; ?></strong></td>
                                            <td>
                                                <i class="fas fa-user-circle me-2 text-primary"></i>
                                                <?php echo SecurityHelper::escapeOutput($customer['full_name']); ?>
                                            </td>
                                            <td><?php echo SecurityHelper::escapeOutput($customer['email']); ?></td>
                                            <td><?php echo SecurityHelper::escapeOutput($customer['phone']); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($customer['created_at'])); ?></td>
                                            <td>
                                                <a href="<?php echo SITE_URL; ?>/public/index.php?page=admin-customer-details&id=<?php echo $customer['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
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

<?php include __DIR__ . '/../layouts/footer.php'; ?>
