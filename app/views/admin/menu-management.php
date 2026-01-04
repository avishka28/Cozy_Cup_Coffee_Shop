<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-5 fw-bold mb-2">
                        <i class="fas fa-utensils me-3"></i>Menu Management
                    </h1>
                    <p class="text-muted">Manage your menu items</p>
                </div>
                <a href="<?php echo SITE_URL; ?>/public/index.php?page=menu-add" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Add New Item
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Menu Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Available</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($items)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                            <p class="text-muted">No menu items found</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td><strong>#<?php echo $item['id']; ?></strong></td>
                                            <td><?php echo SecurityHelper::escapeOutput($item['name']); ?></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php echo SecurityHelper::escapeOutput($item['category']); ?>
                                                </span>
                                            </td>
                                            <td><strong>Rs.<?php echo number_format($item['price'], 2); ?></strong></td>
                                            <td>
                                                <span class="badge bg-<?php echo $item['is_available'] ? 'success' : 'danger'; ?>">
                                                    <?php echo $item['is_available'] ? 'Available' : 'Unavailable'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?php echo SITE_URL; ?>/public/index.php?page=menu-edit&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?php echo SITE_URL; ?>/public/index.php?action=menu-delete&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this item?')">
                                                    <i class="fas fa-trash"></i>
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
